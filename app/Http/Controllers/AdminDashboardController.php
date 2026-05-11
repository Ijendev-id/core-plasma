<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Services\AcademyPortalService;
use App\Services\PackageInventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AcademyPortalService $portalService,
        private readonly PackageInventoryService $packageService,
    ) {}

    public function dashboard(): View
    {
        return view('backend.dashboard', $this->portalService->adminDashboard());
    }

    public function users(): View
    {
        return view('backend.users.index', $this->portalService->adminUsers());
    }

    public function createUser(): View
    {
        return view('backend.users.create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        return $this->portalService->storeUser($request);
    }

    public function editUser(Member $member): View
    {
        return view('backend.users.edit', ['member' => $member]);
    }

    public function updateUser(Request $request, Member $member): RedirectResponse
    {
        return $this->portalService->updateUser($request, $member);
    }

    public function destroyUser(Member $member): RedirectResponse
    {
        return $this->portalService->destroyUser($member);
    }

    public function tryoutDetail(LearningPackage $package): View
    {
        return view('backend.package-inventory.detail', [
            ...$this->packageService->getPackageFormPage($package),
            'package' => $package,
            'questions' => $this->portalService->packageQuestions($package),
        ]);
    }

    public function leaderboard(\Illuminate\Http\Request $request): View
    {
        $packageId = $request->query('package_id');
        return view('backend.leaderboard.index', $this->portalService->adminLeaderboard($packageId ? (int) $packageId : null));
    }
}
