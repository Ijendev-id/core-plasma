<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Models\TryoutSection;
use App\Services\AcademyPortalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AcademyPortalService $portalService,
    ) {}

    public function dashboard(): Response
    {
        return Inertia::render('admin/dashboard', $this->portalService->adminDashboard());
    }

    public function users(): Response
    {
        return Inertia::render('admin/users/index', $this->portalService->adminUsers());
    }

    public function createUser(): Response
    {
        return Inertia::render('admin/users/create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        return $this->portalService->storeUser($request);
    }

    public function editUser(Member $member): Response
    {
        return Inertia::render('admin/users/edit', ['member' => $member]);
    }

    public function updateUser(Request $request, Member $member): RedirectResponse
    {
        return $this->portalService->updateUser($request, $member);
    }

    public function destroyUser(Member $member): RedirectResponse
    {
        return $this->portalService->destroyUser($member);
    }

    public function tryoutDetail(LearningPackage $package): Response
    {
        return Inertia::render('admin/packages/detail', [
            'package' => $package,
            'questions' => $this->portalService->packageQuestions($package),
            'sections' => TryoutSection::query()
                ->whereHas('category', fn ($query) => $query->where('name', $package->category))
                ->orderBy('code')
                ->get(['id', 'code', 'name'])
                ->map(fn (TryoutSection $section): array => [
                    'id' => $section->id,
                    'code' => $section->code,
                    'name' => $section->name,
                ])
                ->all(),
            'questionTarget' => (int) $package->question_count,
        ]);
    }

    public function leaderboard(): Response
    {
        return Inertia::render('admin/leaderboard/index', $this->portalService->adminLeaderboard());
    }
}
