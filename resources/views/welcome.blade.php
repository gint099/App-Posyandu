@extends('layouts.app')

@section('title', 'Beranda - POSYANDU')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <i class="fas fa-heartbeat fa-5x text-success mb-4"></i>
                <h1 class="display-4 fw-bold mb-3">SISTEM INFORMASI POSYANDU</h1>
                <p class="lead text-muted mb-4">
                    Kelola data kesehatan balita dengan mudah dan terstruktur
                </p>
            </div>

            <!-- Main Cards -->
            <div class="row mb-5">
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-lg hover-card">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-search fa-4x text-info mb-3"></i>
                            <h4>Cek Data Pasien</h4>
                            <p class="text-muted">Cari data berdasarkan NIK</p>
                            <a href="#" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="fas fa-search"></i> Cari Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-lg hover-card">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-user-nurse fa-4x text-primary mb-3"></i>
                            <h4>Login Kader</h4>
                            <p class="text-muted">Akses untuk petugas posyandu</p>
                            <a href="{{ route('kader.login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Login Kader
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-lg hover-card">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-user-shield fa-4x text-warning mb-3"></i>
                            <h4>Login Admin</h4>
                            <p class="text-muted">Akses untuk admin kelurahan</p>
                            <a href="{{ route('admin.login') }}" class="btn btn-warning btn-lg text-white">
                                <i class="fas fa-sign-in-alt"></i> Login Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card shadow">
                <div class="card-body p-4">
                    <h5 class="text-center mb-4">Fitur Sistem</h5>
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-notes-medical fa-2x text-success mb-2"></i>
                            <h6>Data Pemeriksaan</h6>
                            <p class="small text-muted">Rekam hasil pemeriksaan BB, TB, LK</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-syringe fa-2x text-primary mb-2"></i>
                            <h6>Data Imunisasi</h6>
                            <p class="small text-muted">Catat riwayat imunisasi lengkap</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                            <h6>Grafik Perkembangan</h6>
                            <p class="small text-muted">Monitor pertumbuhan balita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pencarian NIK -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="searchModalLabel">
                    <i class="fas fa-search"></i> Cari Data Pasien
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="GET">
                    <div class="mb-3">
                        <label for="nik" class="form-label">Masukkan NIK (16 digit)</label>
                        <input
                            type="text"
                            class="form-control form-control-lg"
                            id="nik"
                            name="nik"
                            placeholder="3201012020000001"
                            maxlength="16"
                            required
                        >
                        <small class="text-muted">Masukkan NIK balita untuk melihat data lengkap</small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="fas fa-search"></i> Cari Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush
