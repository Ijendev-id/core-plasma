<?php

namespace App\Http\Controllers;

use App\Models\TryoutCategory;
use App\Models\TryoutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TryoutTaxonomyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/taxonomy/index', [
            'categories' => TryoutCategory::query()
                ->with('sections:id,tryout_category_id,code,name')
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn (TryoutCategory $category): array => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'sections' => $category->sections
                        ->map(fn (TryoutSection $section): array => [
                            'id' => $section->id,
                            'code' => $section->code,
                            'name' => $section->name,
                        ])
                        ->all(),
                ])
                ->all(),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60'],
        ]);

        $name = Str::upper(trim($validated['name']));

        TryoutCategory::query()->firstOrCreate(['name' => $name]);

        return back()->with('status', "Kategori {$name} ditambahkan.");
    }

    public function destroyCategory(TryoutCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('status', "Kategori {$category->name} dihapus.");
    }
}
