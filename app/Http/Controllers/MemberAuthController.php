<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberLoginRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberAuthController extends Controller
{
    public function create(): View
    {
        return view('auth.member-login');
    }

    public function store(MemberLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function register(): View
    {
        return view('auth.member-register');
    }

    public function registerStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $member = Member::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::guard('member')->login($member);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('member')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('member.login');
    }
}
