<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Services\AcademyPortalService;
use Inertia\Inertia;
use Inertia\Response;

class AcademyPortalController extends Controller
{
    public function __construct(
        private readonly AcademyPortalService $service,
    ) {}

    public function dashboard(): Response
    {
        return Inertia::render('portal/dashboard', $this->service->dashboard());
    }

    public function tryouts(): Response
    {
        return Inertia::render('portal/tryouts', $this->service->tryouts());
    }

    public function leaderboard(): Response
    {
        return Inertia::render('portal/leaderboard', $this->service->leaderboard());
    }

    public function play(LearningPackage $package): Response
    {
        return Inertia::render('portal/play', $this->service->play($package));
    }
}
