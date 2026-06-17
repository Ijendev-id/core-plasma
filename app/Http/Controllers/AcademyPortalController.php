<?php

namespace App\Http\Controllers;

use App\Models\LearningPackage;
use App\Services\AcademyPortalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function leaderboard(Request $request): Response
    {
        return Inertia::render('portal/leaderboard', $this->service->leaderboard($request->query('package')));
    }

    public function play(LearningPackage $package): Response|RedirectResponse
    {
        if (! $this->service->ensureEnrolled($package)) {
            return redirect()->route('tryouts.index')
                ->with('error', 'Kuota peserta tryout ini sudah penuh.');
        }

        return Inertia::render('portal/play', $this->service->play($package));
    }

    public function submit(Request $request, LearningPackage $package): RedirectResponse
    {
        $validated = $request->validate([
            'answers' => ['nullable', 'array'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $attempt = $this->service->submitTryout(
            $package,
            $validated['answers'] ?? [],
            (int) ($validated['duration_seconds'] ?? 0),
        );

        return redirect()->route('tryouts.result', [$package, $attempt]);
    }

    public function result(LearningPackage $package, \App\Models\TryoutAttempt $attempt): Response|RedirectResponse
    {
        abort_unless($attempt->learning_package_id === $package->id, 404);

        return Inertia::render('portal/result', $this->service->attemptResult($package, $attempt));
    }
}
