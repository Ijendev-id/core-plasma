<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Services\AcademyPortalService;
use Illuminate\View\View;

class AcademyPortalController extends Controller
{
    public function __construct(
        private readonly AcademyPortalService $service,
    ) {}

    public function dashboard(): View
    {
        return view('portal.dashboard', $this->service->dashboard());
    }

    public function tryouts(): View
    {
        return view('portal.tryouts', $this->service->tryouts());
    }

    public function leaderboard(): View
    {
        return view('portal.leaderboard', $this->service->leaderboard());
    }

    public function play(LearningPackage $package): View
    {
        return view('portal.play', $this->service->play($package));
    }
}
