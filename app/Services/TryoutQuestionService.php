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
            $question = $package->questions()->create([
                'section' => $data['section'],
                'prompt' => $data['prompt'],
                'attachment_path' => $data['attachment_path'] ?? null,
                'order_number' => ((int) $package->questions()->max('order_number')) + 1,
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

    public function deleteQuestion(LearningPackage $package, TryoutQuestion $question): void
    {
        abort_unless($question->learning_package_id === $package->id, 404);

        DB::transaction(function () use ($package, $question): void {
            $question->delete();
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
