<?php

namespace App\Services;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Models\PackageEnrollment;
use App\Models\TryoutAttempt;
use App\Models\TryoutQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AcademyPortalService
{
    /**
     * @return array<string, mixed>
     */
    public function dashboard(): array
    {
        $member = $this->currentMember();
        $progress = $this->memberProgress($member);
        $recentResults = $this->memberRecentResults($member);

        return [
            'member' => $member,
            'progress' => $progress,
            'recentResults' => $recentResults,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function tryouts(): array
    {
        $member = $this->currentMember();

        $myTryouts = $member
            ? TryoutAttempt::query()
                ->with('learningPackage')
                ->where('member_id', $member->id)
                ->whereNotNull('finished_at')
                ->latest('finished_at')
                ->get()
                ->map(fn (TryoutAttempt $attempt): array => [
                    'package_name' => $attempt->learningPackage?->name ?? 'Tryout',
                    'package_slug' => $attempt->learningPackage?->slug ?? '#',
                    'category' => $attempt->learningPackage?->category ?? '-',
                    'score' => $attempt->score,
                    'twk' => $attempt->twk_score,
                    'tiu' => $attempt->tiu_score,
                    'tkp' => $attempt->tkp_score,
                    'status' => $this->attemptStatus($attempt->status),
                    'date' => $attempt->finished_at?->format('d M Y'),
                    'duration' => $this->formatDuration($attempt->duration_seconds),
                ])
                ->all()
            : [];

        $progressByPackage = $member
            ? PackageEnrollment::query()
                ->where('member_id', $member->id)
                ->pluck('progress_percent', 'learning_package_id')
            : collect();

        return [
            'myTryouts' => $myTryouts,
            'myCategories' => collect($myTryouts)->pluck('category')->unique()->values()->all(),
            'packages' => LearningPackage::query()
                ->withCount('questions')
                ->where('status', 'published')
                ->orderBy('id')
                ->get()
                ->map(fn (LearningPackage $package): array => [
                    'name' => $package->name,
                    'slug' => $package->slug,
                    'category' => $package->category,
                    'question_count' => $package->questions_count ?: $package->question_count,
                    'progress' => (int) ($progressByPackage[$package->id] ?? 0),
                    'price' => 'Rp '.number_format($package->price, 0, ',', '.'),
                    'duration' => $package->duration_minutes > 0
                        ? $package->duration_minutes.' menit'
                        : $this->durationFor($package->category),
                ])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function leaderboard(?string $packageSlug = null): array
    {
        $packages = LearningPackage::query()
            ->where('status', 'published')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'leaderboard_price']);

        $selected = $packageSlug
            ? $packages->firstWhere('slug', $packageSlug) ?? $packages->first()
            : $packages->first();

        $attempts = $selected ? $this->topAttempts(12, $selected->id) : collect();
        // Leaderboard terkunci hanya jika ada harga buka (> 0). leaderboard_price = 0 → langsung terlihat.
        $isLocked = $selected && (int) $selected->leaderboard_price > 0;

        return [
            'packages' => $packages->map(fn (LearningPackage $p): array => [
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => $p->leaderboard_price,
            ])->all(),
            'selectedPackage' => $selected ? [
                'name' => $selected->name,
                'slug' => $selected->slug,
                'price' => $selected->leaderboard_price,
            ] : null,
            'isLocked' => $isLocked,
            'podium' => $attempts
                ->take(3)
                ->values()
                ->map(fn (TryoutAttempt $attempt, int $index): array => [
                    'rank' => $index + 1,
                    'name' => $attempt->member?->name ?? 'Member',
                    'score' => $attempt->score,
                ])
                ->all(),
            'rows' => $attempts
                ->skip(3)
                ->values()
                ->map(fn (TryoutAttempt $attempt, int $index): array => [
                    'rank' => $index + 4,
                    'name' => $attempt->member?->name ?? 'Member',
                    'twk' => $attempt->twk_score,
                    'tiu' => $attempt->tiu_score,
                    'tkp' => $attempt->tkp_score,
                    'total' => $attempt->score,
                ])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    /**
     * Pastikan member terdaftar pada tryout, dengan menegakkan limit kuota.
     * Mengembalikan true jika boleh lanjut, false jika kuota penuh.
     */
    public function ensureEnrolled(LearningPackage $package): bool
    {
        $member = $this->currentMember();

        if (! $member) {
            // Tanpa member terautentikasi tidak ada enrollment yang dibuat; biarkan lanjut (mis. preview).
            return true;
        }

        $alreadyEnrolled = PackageEnrollment::query()
            ->where('member_id', $member->id)
            ->where('learning_package_id', $package->id)
            ->exists();

        if ($alreadyEnrolled) {
            return true;
        }

        if (! $package->hasAvailableSlot()) {
            return false;
        }

        PackageEnrollment::query()->create([
            'member_id' => $member->id,
            'learning_package_id' => $package->id,
            'status' => 'active',
            'progress_percent' => 0,
            'enrolled_at' => now(),
        ]);

        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function play(?LearningPackage $package = null): array
    {
        $package ??= LearningPackage::query()->where('status', 'published')->orderBy('id')->first();

        $questions = $package
            ? $package->questions()->with('answers')->where('is_active', true)->orderBy('order_number')->get()
            : collect();

        return [
            'package' => $package ? [
                'name' => $package->name,
                'slug' => $package->slug,
                'category' => $package->category,
                'duration_minutes' => $package->duration_minutes,
            ] : null,
            // Soal dikirim TANPA flag is_correct supaya kunci jawaban tidak bocor ke klien.
            'questions' => $questions->values()->map(fn (TryoutQuestion $q, int $i): array => [
                'id' => $q->id,
                'number' => $i + 1,
                'section' => $q->section,
                'text' => $q->prompt,
                'image' => $q->attachment_path ?: null,
                'answers' => $q->answers->map(fn ($a): array => [
                    'label' => $a->label,
                    'text' => $a->answer_text,
                ])->values()->all(),
            ])->all(),
        ];
    }

    /**
     * Hitung skor dari jawaban member, simpan sebagai TryoutAttempt.
     *
     * @param  array<int, string>  $answers  pemetaan question_id => label (A-E)
     * @return array<string, mixed>
     */
    public function submitTryout(LearningPackage $package, array $answers, int $durationSeconds = 0): TryoutAttempt
    {
        $member = $this->currentMember();
        abort_unless($member !== null, 403, 'Harus login sebagai member.');

        $questions = $package->questions()
            ->with('answers')
            ->where('is_active', true)
            ->orderBy('order_number')
            ->get();

        $sectionScore = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        $correctCount = 0;
        $answeredCount = 0;
        $totalScore = 0;

        foreach ($questions as $question) {
            $chosen = $answers[$question->id] ?? null;

            if ($chosen !== null) {
                $answeredCount++;
            }

            $correctLabel = $question->answers->firstWhere('is_correct', true)?->label;

            if ($chosen !== null && $correctLabel !== null && $chosen === $correctLabel) {
                $correctCount++;
                $points = (int) $question->points;
                $totalScore += $points;

                if (array_key_exists($question->section, $sectionScore)) {
                    $sectionScore[$question->section] += $points;
                }
            }
        }

        $passed = $questions->isNotEmpty() && $correctCount >= (int) ceil($questions->count() * 0.6);

        return TryoutAttempt::query()->create([
            'member_id' => $member->id,
            'learning_package_id' => $package->id,
            'score' => $totalScore,
            'twk_score' => $sectionScore['TWK'],
            'tiu_score' => $sectionScore['TIU'],
            'tkp_score' => $sectionScore['TKP'],
            'answered_count' => $answeredCount,
            'correct_count' => $correctCount,
            'duration_seconds' => max(0, $durationSeconds),
            'status' => $passed ? 'certified' : 'failed',
            'started_at' => now()->subSeconds(max(0, $durationSeconds)),
            'finished_at' => now(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function attemptResult(LearningPackage $package, TryoutAttempt $attempt): array
    {
        $totalQuestions = $package->questions()->where('is_active', true)->count();

        return [
            'package' => [
                'name' => $package->name,
                'slug' => $package->slug,
                'category' => $package->category,
            ],
            'result' => [
                'score' => $attempt->score,
                'twk' => $attempt->twk_score,
                'tiu' => $attempt->tiu_score,
                'tkp' => $attempt->tkp_score,
                'correct' => $attempt->correct_count,
                'answered' => $attempt->answered_count,
                'total' => $totalQuestions,
                'status' => $this->attemptStatus($attempt->status),
                'duration' => $this->formatDuration($attempt->duration_seconds),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function adminDashboard(): array
    {
        return [
            'cards' => [
                ['label' => 'Total Members', 'value' => number_format(Member::query()->count()), 'tone' => 'red'],
                ['label' => 'Active Tryouts', 'value' => number_format(LearningPackage::query()->where('status', 'published')->count()), 'tone' => 'blue'],
                ['label' => 'Question Banks', 'value' => number_format(TryoutQuestion::query()->count()), 'tone' => 'green'],
                ['label' => 'This Month', 'value' => number_format(TryoutAttempt::query()->whereMonth('finished_at', now()->month)->whereYear('finished_at', now()->year)->count()), 'tone' => 'amber'],
            ],
            'recentUsers' => Member::query()
                ->withCount('learningPackages')
                ->latest()
                ->take(5)
                ->get()
                ->map(fn (Member $member): array => [
                    'name' => $member->name,
                    'role' => $member->learning_packages_count.' tryout aktif',
                    'status' => $member->learning_packages_count > 0 ? 'Active' : 'Pending',
                ])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function adminUsers(): array
    {
        return [
            'users' => Member::query()
                ->with(['learningPackages' => fn ($query) => $query->latest('package_enrollments.created_at')])
                ->latest()
                ->take(30)
                ->get()
                ->map(function (Member $member): array {
                    $package = $member->learningPackages->first();
                    $status = $package?->pivot?->status ?? 'inactive';

                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'email' => $member->email,
                        'education' => $member->pendidikan_terakhir ?? '-',
                        'package' => $package?->name ?? 'Belum ada tryout',
                        'status' => ucfirst($status),
                    ];
                })
                ->all(),
        ];
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|string|min:8',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        Member::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,'.$member->id,
            'password' => 'nullable|string|min:8',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        $member->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $member->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroyUser(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    public function adminLeaderboard(): array
    {
        $attempts = $this->topAttempts(20);
        $averageScore = (float) TryoutAttempt::query()->whereNotNull('finished_at')->avg('score');

        return [
            'summary' => [
                ['label' => 'Participants', 'value' => number_format(Member::query()->count())],
                ['label' => 'Average Score', 'value' => number_format($averageScore, 1)],
                ['label' => 'Live Tryout', 'value' => number_format(LearningPackage::query()->where('status', 'published')->count())],
            ],
            'packages' => LearningPackage::query()
                ->orderBy('name')
                ->get(['slug', 'name'])
                ->map(fn (LearningPackage $package): array => [
                    'slug' => $package->slug,
                    'name' => $package->name,
                ])
                ->all(),
            'rows' => $attempts
                ->map(fn (TryoutAttempt $attempt): array => [
                    'name' => $attempt->member?->name ?? 'Member',
                    'package' => $attempt->learningPackage?->name ?? '-',
                    'package_slug' => $attempt->learningPackage?->slug ?? '',
                    'score' => $attempt->score,
                    'time' => $this->formatDuration($attempt->duration_seconds),
                    'status' => $this->attemptStatus($attempt->status),
                ])
                ->all(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function packageQuestions(LearningPackage $package): array
    {
        return $package->questions()
            ->with('answers')
            ->orderBy('order_number')
            ->get()
            ->map(function (TryoutQuestion $question): array {
                $answers = $question->answers->keyBy('label');

                return [
                    'id' => $question->id,
                    'order_number' => $question->order_number,
                    'section' => $question->section,
                    'type' => $question->section,
                    'text' => $question->prompt,
                    'prompt' => $question->prompt,
                    'attachment_path' => $question->attachment_path ?? '',
                    'status' => $question->is_active ? 'Active' : 'Draft',
                    'is_active' => $question->is_active,
                    'points' => $question->points,
                    'answers_count' => $question->answers->count(),
                    'correct_label' => $answers->firstWhere('is_correct', true)?->label ?? 'A',
                    'answers' => collect(['A', 'B', 'C', 'D', 'E'])
                        ->mapWithKeys(fn (string $label): array => [$label => $answers->get($label)?->answer_text ?? ''])
                        ->all(),
                ];
            })
            ->all();
    }

    private function currentMember(): ?Member
    {
        $member = Auth::guard('member')->user();

        if ($member instanceof Member) {
            return $member;
        }

        $email = Auth::guard('web')->user()?->email;

        return $email
            ? Member::query()->where('email', $email)->first()
            : null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function memberProgress(?Member $member): array
    {
        if (! $member) {
            return [];
        }

        // Tryout "sedang berlangsung" = sudah didaftarkan tapi belum punya attempt yang selesai.
        $finishedPackageIds = TryoutAttempt::query()
            ->where('member_id', $member->id)
            ->whereNotNull('finished_at')
            ->pluck('learning_package_id')
            ->unique()
            ->all();

        return PackageEnrollment::query()
            ->with('learningPackage')
            ->where('member_id', $member->id)
            ->whereNotIn('learning_package_id', $finishedPackageIds)
            ->latest('enrolled_at')
            ->take(4)
            ->get()
            ->map(fn (PackageEnrollment $enrollment): array => [
                'title' => $enrollment->learningPackage?->name ?? 'Tryout',
                'slug' => $enrollment->learningPackage?->slug ?? '#',
                'percent' => $enrollment->progress_percent,
                'tag' => $enrollment->learningPackage?->category ?? 'TRYOUT',
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function memberRecentResults(?Member $member): array
    {
        if (! $member) {
            return [];
        }

        $selectedPackageIds = PackageEnrollment::query()
            ->where('member_id', $member->id)
            ->where('status', 'active')
            ->pluck('learning_package_id');

        if ($selectedPackageIds->isEmpty()) {
            return [];
        }

        $results = TryoutAttempt::query()
            ->with('learningPackage')
            ->where('member_id', $member->id)
            ->whereIn('learning_package_id', $selectedPackageIds)
            ->whereNotNull('finished_at')
            ->latest('finished_at')
            ->take(3)
            ->get();

        return $results
            ->map(fn (TryoutAttempt $attempt): array => [
                'title' => $attempt->learningPackage?->name ?? 'Tryout',
                'score' => $attempt->score,
                'status' => $this->attemptStatus($attempt->status),
            ])
            ->all();
    }

    private function topAttempts(int $limit, ?int $packageId = null)
    {
        return TryoutAttempt::query()
            ->with(['member', 'learningPackage'])
            ->when($packageId, fn ($q) => $q->where('learning_package_id', $packageId))
            ->whereNotNull('finished_at')
            ->orderByDesc('score')
            ->orderBy('duration_seconds')
            ->limit($limit)
            ->get();
    }

    /**
     * @return array<string, mixed>
     */
    private function formatPlayableQuestion(?TryoutQuestion $question, int $number, int $total): array
    {
        if (! $question) {
            return [
                'number' => 1,
                'total' => $total,
                'text' => 'Soal belum tersedia untuk paket ini.',
                'image' => 'image/package-bulk-upload.png',
                'answers' => [],
            ];
        }

        return [
            'number' => $number,
            'total' => $total,
            'text' => $question->prompt,
            'image' => $question->attachment_path ?? 'image/package-bulk-upload.png',
            'answers' => $question->answers
                ->map(fn ($answer): array => [
                    'label' => $answer->label,
                    'text' => $answer->answer_text,
                    'state' => $answer->is_correct ? 'selected' : 'normal',
                ])
                ->all(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function questionPalette(int $total, int $current): array
    {
        $visibleTotal = min(max($total, 5), 20);
        $palette = [];

        for ($number = 1; $number <= $visibleTotal; $number++) {
            $palette[] = [
                'number' => $number,
                'state' => $number === $current ? 'current' : ($number < $current ? 'done' : 'empty'),
            ];
        }

        return $palette;
    }

    private function durationFor(string $category): string
    {
        return match ($category) {
            'UNIVERSITY' => '135 menit',
            'CAREER' => '90 menit',
            default => '100 menit',
        };
    }

    private function attemptStatus(string $status): string
    {
        return match ($status) {
            'certified' => 'Certified',
            'failed' => 'Failed',
            'in_progress' => 'In Progress',
            default => ucfirst($status),
        };
    }

    private function formatDuration(int $seconds): string
    {
        return sprintf('%dm %02ds', intdiv($seconds, 60), $seconds % 60);
    }
}
