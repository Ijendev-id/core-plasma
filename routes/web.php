<?php

use App\Http\Controllers\AcademyPortalController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\PackageInventoryController;
use App\Http\Controllers\TryoutQuestionController;
use App\Models\LearningPackage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- RUTE HALAMAN UTAMA (LANDING PAGE) ---
Route::get('/', function () {
    $packages = LearningPackage::where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->limit(3)
        ->get();
    return view('landing.landing', ['packages' => $packages]);
})->name('home');

// --- RUTE AUTHENTICATION (LOGIN) ---
Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

// --- RUTE MENU LAINNYA ---
Route::get('/artikel', function () {
    return Inertia::render('landing');
})->name('artikel');

Route::get('/paket-belajar', function () {
    return Inertia::render('landing');
})->name('paket');

Route::get('/keunggulan', function () {
    return Inertia::render('landing');
})->name('keunggulan');

Route::get('/testimoni', function () {
    return Inertia::render('landing');
})->name('testimoni');

Route::get('/faq', function () {
    return Inertia::render('landing');
})->name('faq');

// --- RUTE MEMBER AUTH ---
Route::middleware('guest:member')->group(function (): void {
    Route::get('/member/login', [MemberAuthController::class, 'create'])->name('member.login');
    Route::post('/member/login', [MemberAuthController::class, 'store'])->name('member.login.store');
    Route::get('/member/register', [MemberAuthController::class, 'register'])->name('member.register');
    Route::post('/member/register', [MemberAuthController::class, 'registerStore'])->name('member.register.store');
});

Route::middleware('guest:web')->group(function (): void {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
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
    Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminDashboardController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{member}/edit', [AdminDashboardController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{member}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{member}', [AdminDashboardController::class, 'destroyUser'])->name('admin.users.destroy');
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
