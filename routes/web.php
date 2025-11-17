<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\KaderController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Kader\PasienController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Kader\ImunisasiController;
use App\Http\Controllers\Kader\PemeriksaanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kader\DashboardController as KaderDashboard;

// ============================================
// HALAMAN PUBLIK (Tanpa Login)
// ============================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/cari-pasien', [PublicController::class, 'search'])->name('public.search');
Route::post('/cari-pasien', [PublicController::class, 'searchResult'])->name('public.search.result');
Route::get('/pasien/{id}', [PublicController::class, 'showPasien'])->name('public.pasien.show');
Route::get('/posyandu', [PublicController::class, 'posyandu'])->name('public.posyandu');
Route::get('/jadwal', [PublicController::class, 'jadwal'])->name('public.jadwal');

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
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    // Kader Management
    Route::resource('kader', KaderController::class);
    Route::post('/kader/{id}/reset-password', [KaderController::class, 'resetPassword'])->name('kader.reset-password');
    // Posyandu Management
    Route::resource('posyandu', PosyanduController::class);
    // Jadwal Management
    Route::resource('jadwal', JadwalController::class);
    // Pasien (View Only)
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.show');
    // Laporan
    Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
    Route::get('/laporan/rekap-rw', [LaporanController::class, 'rekapRW'])->name('laporan.rekap-rw');
});
