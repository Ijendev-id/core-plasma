<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Services\AcademyPortalService;
use App\Services\PackageInventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AcademyPortalService $portalService,
        private readonly PackageInventoryService $packageService,
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
            ...$this->packageService->getPackageFormPage($package),
            'package' => $package,
            'questions' => $this->portalService->packageQuestions($package),
        ]);
    }

    public function leaderboard(): Response
    {
        return Inertia::render('admin/leaderboard/index', $this->portalService->adminLeaderboard());
    }
}
