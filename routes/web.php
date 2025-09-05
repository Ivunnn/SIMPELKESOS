<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Halaman login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update-profile', [\App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-password', [\App\Http\Controllers\AccountController::class, 'updatePassword'])->name('account.updatePassword');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (contoh pakai middleware auth)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// CRUD Residents
Route::resource('residents', ResidentsController::class);
Route::get('residents/{resident}/pdf', [ResidentsController::class, 'downloadPdf'])->name('residents.pdf');
Route::post('/residents/import', [ResidentsController::class, 'import'])->name('residents.import');

// Map
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/residents', [MapController::class, 'getResidents'])->name('map.residents');

// Nested route untuk anggota keluarga
Route::post('residents/{resident}/family-members', [FamilyMemberController::class, 'store'])->name('family-members.store');
Route::delete('residents/{resident}/family-members/{familyMember}', [FamilyMemberController::class, 'destroy'])->name('family-members.destroy');
