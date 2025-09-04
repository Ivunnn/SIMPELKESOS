<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita definisikan route untuk aplikasi kamu.
| Default Laravel sudah punya route auth kalau kamu pakai Breeze/Fortify.
|
*/

// Halaman utama (opsional, bisa redirect ke dashboard)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (misalnya setelah login)
Route::get('/dashboard', function () {
    return view('dashboard'); // resources/views/dashboard.blade.php
})->name('dashboard');

// CRUD Resident
Route::resource('residents', ResidentsController::class);
Route::get('residents/{resident}/pdf', [ResidentsController::class, 'downloadPdf'])->name('residents.pdf');
Route::post('/residents/import', [ResidentsController::class, 'import'])->name('residents.import');

