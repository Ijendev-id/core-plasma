<?php

namespace App\Http\Controllers;

use App\Models\TryoutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TryoutSectionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tryout_category_id' => ['required', 'exists:tryout_categories,id'],
            'code' => ['required', 'string', 'max:24'],
            'name' => ['nullable', 'string', 'max:120'],
        ]);

        $code = Str::upper(trim($validated['code']));

        TryoutSection::query()->firstOrCreate(
            [
                'tryout_category_id' => $validated['tryout_category_id'],
                'code' => $code,
            ],
            ['name' => $validated['name'] ?? null],
        );

        return back()->with('status', "Section {$code} ditambahkan.");
    }

    public function destroy(TryoutSection $section): RedirectResponse
    {
        $section->delete();

        return back()->with('status', "Section {$section->code} dihapus.");
    }
}
