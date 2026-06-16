<?php

namespace App\Http\Controllers;

use App\Http\Requests\TryoutQuestionStoreRequest;
use App\Models\LearningPackage;
use App\Models\TryoutQuestion;
use App\Services\TryoutQuestionService;
use Illuminate\Http\RedirectResponse;

class TryoutQuestionController extends Controller
{
    public function __construct(
        private readonly TryoutQuestionService $service,
    ) {}

    public function store(TryoutQuestionStoreRequest $request, LearningPackage $package): RedirectResponse
    {
        $this->service->createQuestion($package, $request->validated());

        return to_route('admin.packages.tryout', $package)
            ->with('status', 'Soal berhasil ditambahkan.');
    }

    public function update(TryoutQuestionStoreRequest $request, LearningPackage $package, TryoutQuestion $question): RedirectResponse
    {
        $this->service->updateQuestion($package, $question, $request->validated());

        return to_route('admin.packages.tryout', $package)
            ->with('status', 'Soal berhasil diperbarui.');
    }

    public function destroy(LearningPackage $package, TryoutQuestion $question): RedirectResponse
    {
        $this->service->deleteQuestion($package, $question);

        return to_route('admin.packages.tryout', $package)
            ->with('status', 'Soal berhasil dihapus.');
    }
}
