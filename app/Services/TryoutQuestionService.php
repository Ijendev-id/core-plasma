<?php

namespace App\Services;

use App\Models\LearningPackage;
use App\Models\TryoutQuestion;
use Illuminate\Support\Facades\DB;

class TryoutQuestionService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function createQuestion(LearningPackage $package, array $data): TryoutQuestion
    {
        return DB::transaction(function () use ($package, $data): TryoutQuestion {
            $count = (int) $package->questions()->count();
            // Posisi 1-based yang diminta; default ke akhir. Dibatasi 1..count+1.
            $position = isset($data['position'])
                ? max(1, min((int) $data['position'], $count + 1))
                : $count + 1;

            // Geser turun soal di posisi >= $position agar ada celah (hindari bentrok unique).
            $this->shiftFrom($package, $position, $count);

            $question = $package->questions()->create([
                'section' => $data['section'],
                'prompt' => $data['prompt'],
                'attachment_path' => $data['attachment_path'] ?? null,
                'order_number' => $position,
                'points' => (int) $data['points'],
                'is_active' => (bool) ($data['is_active'] ?? false),
            ]);

            foreach (['A', 'B', 'C', 'D', 'E'] as $label) {
                $question->answers()->create([
                    'label' => $label,
                    'answer_text' => $data['answers'][$label],
                    'is_correct' => $data['correct_label'] === $label,
                ]);
            }

            $this->syncPackageQuestionCount($package);

            return $question->load('answers');
        });
    }

    /**
     * Susun ulang urutan soal sesuai daftar id yang diberikan.
     *
     * @param  array<int, int>  $orderedIds
     */
    public function reorderQuestions(LearningPackage $package, array $orderedIds): void
    {
        DB::transaction(function () use ($package, $orderedIds): void {
            $valid = $package->questions()->pluck('id')->all();
            $ids = array_values(array_filter($orderedIds, fn ($id): bool => in_array((int) $id, $valid, true)));

            // Fase 1: pindah ke offset besar agar tidak bentrok unique saat menata ulang.
            $offset = 1000;
            foreach ($ids as $index => $id) {
                $package->questions()->whereKey($id)->update(['order_number' => $offset + $index]);
            }

            // Fase 2: tata ke 1..n sesuai urutan baru.
            foreach ($ids as $index => $id) {
                $package->questions()->whereKey($id)->update(['order_number' => $index + 1]);
            }
        });
    }

    /**
     * Geser order_number soal pada posisi >= $from menjadi +1 (dari belakang agar aman).
     */
    private function shiftFrom(LearningPackage $package, int $from, int $count): void
    {
        for ($pos = $count; $pos >= $from; $pos--) {
            $package->questions()
                ->where('order_number', $pos)
                ->update(['order_number' => $pos + 1]);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateQuestion(LearningPackage $package, TryoutQuestion $question, array $data): TryoutQuestion
    {
        abort_unless($question->learning_package_id === $package->id, 404);

        return DB::transaction(function () use ($question, $data): TryoutQuestion {
            $question->update([
                'section' => $data['section'],
                'prompt' => $data['prompt'],
                'attachment_path' => $data['attachment_path'] ?? null,
                'points' => (int) $data['points'],
                'is_active' => (bool) ($data['is_active'] ?? false),
            ]);

            foreach (['A', 'B', 'C', 'D', 'E'] as $label) {
                $question->answers()->updateOrCreate(
                    ['label' => $label],
                    [
                        'answer_text' => $data['answers'][$label],
                        'is_correct' => $data['correct_label'] === $label,
                    ],
                );
            }

            return $question->load('answers');
        });
    }

    public function deleteQuestion(LearningPackage $package, TryoutQuestion $question): void
    {
        abort_unless($question->learning_package_id === $package->id, 404);

        DB::transaction(function () use ($package, $question): void {
            $question->delete();

            // Rapikan order_number jadi 1..n tanpa celah.
            $package->questions()->orderBy('order_number')->get()
                ->each(function (TryoutQuestion $q, int $index): void {
                    $q->update(['order_number' => $index + 1]);
                });

            $this->syncPackageQuestionCount($package);
        });
    }

    private function syncPackageQuestionCount(LearningPackage $package): void
    {
        $package->forceFill([
            'question_count' => $package->questions()->count(),
        ])->save();
    }
}
