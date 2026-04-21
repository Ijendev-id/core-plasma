<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Services\AcademyPortalService;
use App\Services\PackageInventoryService;
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

    public function tryoutDetail(LearningPackage $package): View
    {
        return view('backend.package-inventory.detail', [
            ...$this->packageService->getPackageFormPage($package),
            'package' => $package,
            'questions' => $this->portalService->packageQuestions($package),
        ]);
    }

    public function leaderboard(): View
    {
        return view('backend.leaderboard.index', $this->portalService->adminLeaderboard());
    }
}
