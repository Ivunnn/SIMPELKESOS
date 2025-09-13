<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login & Logout
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route ini hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Akun
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

    // CRUD Residents
    Route::resource('residents', ResidentsController::class);
    Route::get('residents/{resident}/pdf', [ResidentsController::class, 'downloadPdf'])->name('residents.pdf');
    Route::post('/residents/import', [ResidentsController::class, 'import'])->name('residents.import');
    // Export data
Route::get('/residents/export/excel', [ResidentsController::class, 'exportExcel'])->name('residents.export.excel');
Route::get('/residents/export/pdf', [ResidentsController::class, 'exportPdf'])->name('residents.export.pdf');


    // Map
    Route::get('/map', [MapController::class, 'index'])->name('map.index');
    Route::get('/map/residents', [MapController::class, 'getResidents'])->name('map.residents');
    Route::get('/map/kecamatan', [App\Http\Controllers\MapController::class, 'getKecamatan'])
    ->name('map.kecamatan');
Route::get('/api/residents', [MapController::class, 'getResidents'])->name('map.residents');
Route::get('/map/export/excel', [MapController::class, 'exportExcel'])->name('map.export.excel');
Route::get('/map/export/pdf', [MapController::class, 'exportPdf'])->name('map.export.pdf');



    // Nested route untuk anggota keluarga
    Route::post('residents/{resident}/family-members', [FamilyMemberController::class, 'store'])->name('family-members.store');
    Route::delete('residents/{resident}/family-members/{familyMember}', [FamilyMemberController::class, 'destroy'])->name('family-members.destroy');
});
