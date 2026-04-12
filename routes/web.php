<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


// Route::get('/', function () {
//     return view('landing');
// });


// Rute untuk halaman utama
Route::get('/', function () {
    return view('landing.landing');
})->name('home');

// Rute untuk halaman lainnya (Contoh)
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


// Route::inertia('/', 'welcome', [
//     'canRegister' => Features::enabled(Features::registration()),
// ])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::inertia('dashboard', 'dashboard')->name('dashboard');
// });

// require __DIR__.'/settings.php';
