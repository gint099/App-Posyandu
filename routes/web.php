<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Kader\DashboardController as KaderDashboard;
use App\Http\Controllers\Kader\PasienController;
use App\Http\Controllers\Kader\PemeriksaanController;
use App\Http\Controllers\Kader\ImunisasiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
// ============================================
// HALAMAN PUBLIK (Tanpa Login)
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// AUTHENTICATION ROUTES
// ============================================

// Login Kader
Route::get('/kader/login', [LoginController::class, 'showKaderLogin'])->name('kader.login');
Route::post('/kader/login', [LoginController::class, 'kaderLogin'])->name('kader.login.post');

// Login Admin
Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.post');

// Logout (untuk semua role)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// KADER ROUTES (Butuh Login sebagai Kader)
// ============================================
Route::middleware(['auth', 'role:kader'])->prefix('kader')->name('kader.')->group(function () {
    // Imunisasi
    Route::resource('imunisasi', ImunisasiController::class)->except(['index', 'show']);
    // Dashboard Kader
    Route::get('/dashboard', [KaderDashboard::class, 'index'])->name('dashboard');
    // Pemeriksaan
    Route::resource('pemeriksaan', PemeriksaanController::class);
    // Pasien
    Route::resource('pasien', PasienController::class);

});

// ============================================
// ADMIN ROUTES (Butuh Login sebagai Admin)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Route lainnya akan ditambahkan di tahap 5
});
