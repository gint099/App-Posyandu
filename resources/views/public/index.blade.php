@extends('layouts.app')

@section('title', 'Beranda - POSYANDU')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-3">SISTEM INFORMASI POSYANDU</h1>
                    <p class="lead mb-4">
                        Monitoring kesehatan balita dengan sistem yang terintegrasi dan mudah diakses
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('public.search') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-search"></i> Cari Data Pasien
                        </a>
                        <a href="{{ route('public.jadwal') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-calendar"></i> Lihat Jadwal
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-heartbeat" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-hospital fa-3x text-success mb-3"></i>
                        <h2 class="fw-bold">{{ $totalPosyandu }}</h2>
                        <p class="text-muted mb-0">Posyandu Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h2 class="fw-bold">{{ $totalPasien }}</h2>
                        <p class="text-muted mb-0">Balita Terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-calendar-check fa-3x text-info mb-3"></i>
                        <h2 class="fw-bold">{{ $jadwalTerdekat->count() }}</h2>
                        <p class="text-muted mb-0">Jadwal Minggu Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Terdekat -->
    @if($jadwalTerdekat->count() > 0)
    <div class="bg-light py-5">
        <div class="container">
            <h3 class="text-center mb-4">
                <i class="fas fa-calendar-alt text-primary"></i> Jadwal Pelayanan Terdekat
            </h3>
            <div class="row">
                @foreach($jadwalTerdekat as $jadwal)
                    <div class="col-md-6 mb-3">
                        <div class="card border-start border-primary border-4 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">{{ $jadwal->posyandu->nama_posyandu }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-map-marker-alt"></i> RW {{ $jadwal->posyandu->rw }} - {{ $jadwal->posyandu->alamat }}
                                        </p>
                                        <p class="mb-1">
                                            <i class="fas fa-calendar"></i>
                                            <strong>{{ $jadwal->tanggal_pelayanan->isoFormat('dddd, D MMMM Y') }}</strong>
                                        </p>
                                        <p class="mb-1">
                                            <i class="fas fa-clock"></i> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                        </p>
                                        <span class="badge bg-info">{{ $jadwal->jenis_pelayanan }}</span>
                                    </div>
                                    @php
                                        $daysUntil = now()->diffInDays($jadwal->tanggal_pelayanan);
                                    @endphp
                                    @if($daysUntil == 0)
                                        <span class="badge bg-danger">Hari Ini</span>
                                    @elseif($daysUntil == 1)
                                        <span class="badge bg-warning">Besok</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $daysUntil }} Hari</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('public.jadwal') }}" class="btn btn-primary">
                    <i class="fas fa-calendar"></i> Lihat Semua Jadwal
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Fitur Section -->
    <div class="container my-5">
        <h3 class="text-center mb-5">Fitur Layanan</h3>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-search fa-3x text-primary"></i>
                    </div>
                    <h5>Cari Data Pasien</h5>
                    <p class="text-muted">Akses data menggunakan NIK</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-notes-medical fa-3x text-success"></i>
                    </div>
                    <h5>Riwayat Pemeriksaan</h5>
                    <p class="text-muted">Lihat data BB, TB, LK</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-syringe fa-3x text-info"></i>
                    </div>
                    <h5>Data Imunisasi</h5>
                    <p class="text-muted">Riwayat imunisasi lengkap</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-chart-line fa-3x text-warning"></i>
                    </div>
                    <h5>Grafik Perkembangan</h5>
                    <p class="text-muted">Monitor pertumbuhan balita</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary text-white py-5">
        <div class="container text-center">
            <h3 class="mb-3">Akses untuk Petugas</h3>
            <p class="mb-4">Login sebagai Kader atau Admin untuk mengelola data</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('kader.login') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-user-nurse"></i> Login Kader
                </a>
                <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-shield"></i> Login Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4CAF50 0%, #2196F3 100%);
    }
    .min-vh-50 {
        min-height: 50vh;
    }
</style>
@endpush
