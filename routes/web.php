<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyMemberController;

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

Route::get('/', [AuthController::class, 'login']);
Route::post('/', [AuthController::class, 'authenticate']);

// Dashboard (misalnya setelah login)
Route::get('/dashboard', function () {
    return view('dashboard'); // resources/views/dashboard.blade.php
})->name('dashboard');

// CRUD Resident
Route::resource('residents', ResidentsController::class);
Route::get('residents/{resident}/pdf', [ResidentsController::class, 'downloadPdf'])->name('residents.pdf');
Route::post('/residents/import', [ResidentsController::class, 'import'])->name('residents.import');

//Map
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/residents', [MapController::class, 'getResidents'])->name('map.residents');

Route::resource('residents', ResidentsController::class);

// nested route untuk anggota keluarga
Route::post('residents/{resident}/family-members', [FamilyMemberController::class, 'store'])->name('family-members.store');
Route::delete('residents/{resident}/family-members/{familyMember}', [FamilyMemberController::class, 'destroy'])->name('family-members.destroy');



