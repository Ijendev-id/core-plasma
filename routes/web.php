<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


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

// Aksi proses login (mengarahkan ke controller jika ada)
// Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);


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
