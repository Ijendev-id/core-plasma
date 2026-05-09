<?php

namespace Database\Seeders;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Models\PackageEnrollment;
use App\Models\TryoutAttempt;
use App\Models\TryoutQuestion;
use Illuminate\Database\Seeder;

class TryoutBackendSeeder extends Seeder
{
    /**
     * Seed question banks, enrollments, and leaderboard attempts.
     */
    public function run(): void
    {
        $packages = LearningPackage::query()->orderBy('id')->take(4)->get();
        $members = Member::query()->orderBy('id')->get();

        if ($packages->isEmpty() || $members->isEmpty()) {
            return;
        }

        foreach ($packages as $packageIndex => $package) {
            $this->seedQuestions($package);

            foreach ($members->take(6) as $memberIndex => $member) {
                PackageEnrollment::query()->updateOrCreate(
                    [
                        'member_id' => $member->id,
                        'learning_package_id' => $package->id,
                    ],
                    [
                        'status' => $package->status === 'published' ? 'active' : 'pending',
                        'progress_percent' => min(98, 32 + ($memberIndex * 9) + ($packageIndex * 6)),
                        'enrolled_at' => now()->subDays($memberIndex + $packageIndex + 1),
                    ],
                );
            }
        }

        foreach ($members as $index => $member) {
            $package = $packages[$index % max(1, $packages->count())];
            $twk = 120 + (($index * 7) % 35);
            $tiu = 130 + (($index * 11) % 38);
            $tkp = 135 + (($index * 13) % 45);
            $score = $twk + $tiu + $tkp;

            TryoutAttempt::query()->updateOrCreate(
                [
                    'member_id' => $member->id,
                    'learning_package_id' => $package->id,
                ],
                [
                    'score' => $score,
                    'twk_score' => $twk,
                    'tiu_score' => $tiu,
                    'tkp_score' => $tkp,
                    'answered_count' => 100,
                    'correct_count' => min(100, (int) floor($score / 5)),
                    'duration_seconds' => 2500 + ($index * 173),
                    'status' => $score >= 430 ? 'certified' : 'failed',
                    'started_at' => now()->subDays($index + 1)->subMinutes(72),
                    'finished_at' => now()->subDays($index + 1)->startOfMinute(),
                ],
            );
        }
    }

    private function seedQuestions(LearningPackage $package): void
    {
        $questions = [
            [
                'section' => 'TWK',
                'prompt' => 'Nilai-nilai Pancasila dalam kehidupan sehari-hari paling tepat diterapkan melalui sikap berikut, kecuali...',
                'answers' => ['Mengutamakan musyawarah', 'Menghargai perbedaan', 'Menolak hasil kesepakatan', 'Menjaga persatuan', 'Bersikap adil'],
                'correct' => 'C',
            ],
            [
                'section' => 'TIU',
                'prompt' => 'Jika semua peserta rajin belajar dan sebagian peserta mengikuti tryout, simpulan yang paling tepat adalah...',
                'answers' => ['Semua peserta mengikuti tryout', 'Sebagian peserta rajin belajar', 'Tidak ada peserta rajin', 'Tryout tidak penting', 'Semua simpulan salah'],
                'correct' => 'B',
            ],
            [
                'section' => 'TKP',
                'prompt' => 'Saat rekan kerja kesulitan menyelesaikan tugas mendadak, respons terbaik adalah...',
                'answers' => ['Membiarkan saja', 'Membantu sesuai prioritas pekerjaan', 'Mengkritik di depan tim', 'Menunda semua tugas pribadi', 'Melaporkan tanpa solusi'],
                'correct' => 'B',
            ],
            [
                'section' => 'TIU',
                'prompt' => 'Sebuah mobil mainan bergerak lurus dengan percepatan tetap. Jika pada detik ke-2 kecepatannya 4 m/s dan pada detik ke-5 menjadi 10 m/s, jarak tempuh dari detik ke-2 sampai ke-5 adalah...',
                'answers' => ['6 meter', '18 meter', '21 meter', '24 meter', '27 meter'],
                'correct' => 'C',
            ],
            [
                'section' => 'TKP',
                'prompt' => 'Dalam pelayanan publik, prioritas utama ketika menghadapi antrean panjang adalah...',
                'answers' => ['Mengabaikan antrean', 'Membuat alur layanan jelas', 'Meminta semua menunggu tanpa informasi', 'Melayani kenalan dulu', 'Menutup loket'],
                'correct' => 'B',
            ],
        ];

        foreach ($questions as $index => $question) {
            $model = TryoutQuestion::query()->updateOrCreate(
                [
                    'learning_package_id' => $package->id,
                    'order_number' => $index + 1,
                ],
                [
                    'section' => $question['section'],
                    'prompt' => $question['prompt'],
                    'attachment_path' => $index === 3 ? 'image/package-bulk-upload.png' : null,
                    'points' => 5,
                    'is_active' => true,
                ],
            );

            foreach (['A', 'B', 'C', 'D', 'E'] as $answerIndex => $label) {
                $model->answers()->updateOrCreate(
                    ['label' => $label],
                    [
                        'answer_text' => $question['answers'][$answerIndex],
                        'is_correct' => $label === $question['correct'],
                    ],
                );
            }
        }
    }
}
