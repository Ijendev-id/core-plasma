<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageInventoryIndexRequest;
use App\Http\Requests\PackageInventoryStoreRequest;
use App\Http\Requests\PackageInventoryUpdateRequest;
use App\Models\LearningPackage;
use App\Services\PackageInventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageInventoryController extends Controller
{
    public function __construct(
        private readonly PackageInventoryService $service,
    ) {}

    public function index(PackageInventoryIndexRequest $request): View
    {
        return view('backend.package-inventory.index', $this->service->getPackageInventoryPage($request->validated()));
    }

    public function create(): View
    {
        return view('backend.package-inventory.form', [
            ...$this->service->getPackageFormPage(),
            'title' => 'Create New Package',
            'action' => route('admin.packages.store'),
            'method' => 'POST',
        ]);
    }

    public function store(PackageInventoryStoreRequest $request): RedirectResponse
    {
        $package = $this->service->createPackage($request->validated());

        return to_route('admin.packages.edit', $package)
            ->with('status', 'Package berhasil dibuat.');
    }

    public function edit(LearningPackage $package): View
    {
        return view('backend.package-inventory.form', [
            ...$this->service->getPackageFormPage($package),
            'title' => 'Edit Package',
            'action' => route('admin.packages.update', $package),
            'method' => 'PUT',
        ]);
    }

    public function update(PackageInventoryUpdateRequest $request, LearningPackage $package): RedirectResponse
    {
        $package = $this->service->updatePackage($package, $request->validated());

        return to_route('admin.packages.edit', $package)
            ->with('status', 'Package berhasil diperbarui.');
    }

    public function destroy(LearningPackage $package): RedirectResponse
    {
        $this->service->deletePackage($package);

        return to_route('admin.packages.index')
            ->with('status', 'Package berhasil dihapus.');
    }
}
