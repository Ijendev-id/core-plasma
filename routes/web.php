<?php

use App\Http\Controllers\AcademyPortalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\PackageInventoryController;
use App\Http\Controllers\TryoutQuestionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('landing');
// });

// --- RUTE HALAMAN UTAMA (LANDING PAGE) ---
Route::get('/', function () {
    return view('landing.landing');
})->name('home');

// --- RUTE AUTHENTICATION (LOGIN) ---
// Menampilkan form login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/register', function () {
    return view('auth.register');
})->name('register');


// --- RUTE MENU LAINNYA ---
Route::get('/artikel', function () {
    return view('landing.artikel');
})->name('artikel');

Route::get('/paket-belajar', function () {
    return view('landing.paket');
})->name('paket');

Route::get('/keunggulan', function () {
    return view('landing.landing');
})->name('keunggulan');

Route::get('/testimoni', function () {
    return view('landing.landing');
})->name('testimoni');

Route::get('/faq', function () {
    return view('landing.landing');
})->name('faq');

Route::middleware('guest:member')->group(function (): void {
    Route::get('/member/login', [MemberAuthController::class, 'create'])->name('member.login');
    Route::post('/member/login', [MemberAuthController::class, 'store'])->name('member.login.store');
    Route::get('/member/register', [MemberAuthController::class, 'register'])->name('member.register');
    Route::post('/member/register', [MemberAuthController::class, 'registerStore'])->name('member.register.store');
});

Route::post('/member/logout', [MemberAuthController::class, 'destroy'])
    ->middleware('auth:member')
    ->name('member.logout');

Route::middleware('auth:member')->group(function (): void {
    Route::get('/dashboard', [AcademyPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/tryouts', [AcademyPortalController::class, 'tryouts'])->name('tryouts.index');
    Route::get('/leaderboard', [AcademyPortalController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/tryouts/{package}/play', [AcademyPortalController::class, 'play'])->name('tryouts.play');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/admin', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/leaderboard', [AdminDashboardController::class, 'leaderboard'])->name('admin.leaderboard.index');
    Route::get('/admin/packages', [PackageInventoryController::class, 'index'])->name('admin.packages.index');
    Route::get('/admin/packages/create', [PackageInventoryController::class, 'create'])->name('admin.packages.create');
    Route::post('/admin/packages', [PackageInventoryController::class, 'store'])->name('admin.packages.store');
    Route::get('/admin/packages/{package}/edit', [PackageInventoryController::class, 'edit'])->name('admin.packages.edit');
    Route::put('/admin/packages/{package}', [PackageInventoryController::class, 'update'])->name('admin.packages.update');
    Route::delete('/admin/packages/{package}', [PackageInventoryController::class, 'destroy'])->name('admin.packages.destroy');
    Route::get('/admin/packages/{package}/tryout', [AdminDashboardController::class, 'tryoutDetail'])->name('admin.packages.tryout');
    Route::post('/admin/packages/{package}/questions', [TryoutQuestionController::class, 'store'])->name('admin.packages.questions.store');
    Route::delete('/admin/packages/{package}/questions/{question}', [TryoutQuestionController::class, 'destroy'])->name('admin.packages.questions.destroy');
});

require __DIR__.'/settings.php';
