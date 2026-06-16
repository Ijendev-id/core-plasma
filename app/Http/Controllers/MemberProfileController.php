<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\ProfilePhotoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class MemberProfileController extends Controller
{
    public function __construct(
        private readonly ProfilePhotoService $photos,
    ) {}

    public function edit(): Response
    {
        $member = $this->member();

        return Inertia::render('portal/profile', [
            'profile' => [
                'name' => $member->name,
                'email' => $member->email,
                'pendidikan_terakhir' => $member->pendidikan_terakhir,
                'photo_url' => $this->photos->url($member->photo_profile),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $member = $this->member();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email,'.$member->id],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
            // Hardening upload: hanya gambar, maks 2MB, dimensi wajar.
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=4000,max_height=4000'],
        ]);

        $member->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
        ]);

        if ($request->hasFile('photo')) {
            $member->photo_profile = $this->photos->store($member, $request->file('photo'));
        }

        $member->save();

        return to_route('member.profile.edit')->with('status', 'Profil berhasil diperbarui.');
    }

    private function member(): Member
    {
        $member = Auth::guard('member')->user();
        abort_unless($member instanceof Member, 403);

        return $member;
    }
}
