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
        $ranking = $this->rankingRows(4);

        return [
            'member' => $member,
            'progress' => $progress,
            'recentResults' => $recentResults,
            'ranking' => $ranking,
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
            'packages' => LearningPackage::query()
                ->withCount('questions')
                ->where('status', 'published')
                ->orderBy('id')
                ->take(6)
                ->get()
                ->map(fn (LearningPackage $package): array => [
                    'name' => $package->name,
                    'slug' => $package->slug,
                    'category' => $package->category,
                    'question_count' => $package->questions_count ?: $package->question_count,
                    'progress' => (int) ($progressByPackage[$package->id] ?? 0),
                    'price' => 'Rp '.number_format($package->price, 0, ',', '.'),
                    'duration' => $this->durationFor($package->category),
                ])
                ->all(),
            'articles' => [
                ['title' => 'Rutin Belajar Bareng Mentor', 'description' => 'Latihan terarah dengan pembahasan singkat dan tajam.'],
                ['title' => 'Intensif Tryout SKD', 'description' => 'Peta kekuatanmu sebelum masuk simulasi utama.'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function leaderboard(): array
    {
        $attempts = $this->topAttempts(12);

        return [
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
    public function play(?LearningPackage $package = null): array
    {
        $package ??= LearningPackage::query()->where('status', 'published')->orderBy('id')->first();
        $questions = $package
            ? $package->questions()->with('answers')->where('is_active', true)->orderBy('order_number')->get()
            : collect();
        $question = $questions->skip(3)->first() ?? $questions->first();
        $questionIndex = $question
            ? $questions->values()->search(fn (TryoutQuestion $item): bool => $item->id === $question->id)
            : false;
        $currentNumber = $questionIndex === false ? 1 : $questionIndex + 1;
        $totalQuestions = $questions->isNotEmpty()
            ? $questions->count()
            : max($package?->question_count ?? 1, 1);

        return [
            'package' => $package,
            'question' => $this->formatPlayableQuestion($question, $currentNumber, $totalQuestions),
            'palette' => $this->questionPalette($totalQuestions, $currentNumber),
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
                    'role' => $member->learning_packages_count.' paket aktif',
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
                        'package' => $package?->name ?? 'Belum ada paket',
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
            'rows' => $attempts
                ->map(fn (TryoutAttempt $attempt): array => [
                    'name' => $attempt->member?->name ?? 'Member',
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
            ->withCount('answers')
            ->orderBy('order_number')
            ->get()
            ->map(fn (TryoutQuestion $question): array => [
                'id' => $question->id,
                'type' => $question->section,
                'text' => $question->prompt,
                'status' => $question->is_active ? 'Active' : 'Draft',
                'points' => $question->points,
                'answers_count' => $question->answers_count,
            ])
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
        $progress = $member
            ? PackageEnrollment::query()
                ->with('learningPackage')
                ->where('member_id', $member->id)
                ->latest('enrolled_at')
                ->take(2)
                ->get()
                ->map(fn (PackageEnrollment $enrollment): array => [
                    'title' => $enrollment->learningPackage?->name ?? 'Tryout',
                    'percent' => $enrollment->progress_percent,
                    'tag' => $enrollment->learningPackage?->category ?? 'TRYOUT',
                ])
            : collect();

        if ($progress->isEmpty()) {
            $progress = LearningPackage::query()
                ->where('status', 'published')
                ->orderBy('id')
                ->take(2)
                ->get()
                ->map(fn (LearningPackage $package): array => [
                    'title' => $package->name,
                    'percent' => 0,
                    'tag' => $package->category,
                ]);
        }

        return $progress->values()->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function memberRecentResults(?Member $member): array
    {
        $results = $member
            ? TryoutAttempt::query()
                ->with('learningPackage')
                ->where('member_id', $member->id)
                ->whereNotNull('finished_at')
                ->latest('finished_at')
                ->take(3)
                ->get()
            : collect();

        if ($results->isEmpty()) {
            $results = TryoutAttempt::query()
                ->with('learningPackage')
                ->whereNotNull('finished_at')
                ->latest('finished_at')
                ->take(3)
                ->get();
        }

        return $results
            ->map(fn (TryoutAttempt $attempt): array => [
                'title' => $attempt->learningPackage?->name ?? 'Tryout',
                'score' => $attempt->score,
                'status' => $this->attemptStatus($attempt->status),
            ])
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function rankingRows(int $limit): array
    {
        return $this->topAttempts($limit)
            ->map(fn (TryoutAttempt $attempt): array => [
                'name' => $attempt->member?->name ?? 'Member',
                'score' => $attempt->score,
            ])
            ->all();
    }

    private function topAttempts(int $limit)
    {
        return TryoutAttempt::query()
            ->with(['member', 'learningPackage'])
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
