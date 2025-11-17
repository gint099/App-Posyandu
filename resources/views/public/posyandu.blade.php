@extends('layouts.app')

@section('title', 'Daftar Posyandu')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <i class="fas fa-hospital fa-4x text-success mb-3"></i>
        <h2 class="fw-bold">Daftar Posyandu</h2>
        <p class="text-muted">Informasi lengkap posyandu di wilayah kelurahan</p>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-hospital fa-3x text-success mb-2"></i>
                    <h3 class="fw-bold">{{ $posyandus->count() }}</h3>
                    <p class="text-muted mb-0">Posyandu Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-primary mb-2"></i>
                    <h3 class="fw-bold">{{ $posyandus->sum('pasiens_count') }}</h3>
                    <p class="text-muted mb-0">Total Balita</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-map-marked-alt fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold">{{ $posyandus->pluck('rw')->unique()->count() }}</h3>
                    <p class="text-muted mb-0">RW Terlayani</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Posyandu -->
    @if($posyandus->count() > 0)
        <div class="row">
            @foreach($posyandus as $posyandu)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-start border-success border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-success mb-2">RW {{ $posyandu->rw }}</span>
                                    <h4 class="mb-1">{{ $posyandu->nama_posyandu }}</h4>
                                    <p class="text-muted mb-0">{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</p>
                                </div>
                                <i class="fas fa-hospital fa-2x text-success opacity-25"></i>
                            </div>

                            <hr>

                            <!-- Info Posyandu -->
                            <div class="mb-3">
                                <h6 class="text-muted small mb-2">ALAMAT</h6>
                                <p class="mb-0">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    {{ $posyandu->alamat }}
                                </p>
                            </div>

                            @if($posyandu->ketua)
                            <div class="mb-3">
                                <h6 class="text-muted small mb-2">KETUA POSYANDU</h6>
                                <p class="mb-0">
                                    <i class="fas fa-user text-primary"></i>
                                    {{ $posyandu->ketua }}
                                </p>
                            </div>
                            @endif

                            @if($posyandu->phone)
                            <div class="mb-3">
                                <h6 class="text-muted small mb-2">KONTAK</h6>
                                <p class="mb-0">
                                    <i class="fas fa-phone text-success"></i>
                                    <a href="tel:{{ $posyandu->phone }}" class="text-decoration-none">
                                        {{ $posyandu->phone }}
                                    </a>
                                </p>
                            </div>
                            @endif

                            <!-- Statistik -->
                            <div class="bg-light rounded p-3 mt-3">
                                <div class="row text-center">
                                    <div class="col">
                                        <h4 class="mb-0 text-primary">{{ $posyandu->pasiens_count }}</h4>
                                        <small class="text-muted">Balita</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="mt-3">
                                <a href="{{ route('public.jadwal', ['posyandu_id' => $posyandu->id]) }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-calendar-alt"></i> Lihat Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-hospital fa-4x text-muted mb-3"></i>
                <h5>Belum Ada Data Posyandu</h5>
                <p class="text-muted">Data posyandu akan muncul di sini</p>
            </div>
        </div>
    @endif

    <!-- Map Placeholder -->
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-map-marked-alt text-info"></i> Peta Sebaran Posyandu</h5>
        </div>
        <div class="card-body text-center py-5 bg-light">
            <i class="fas fa-map fa-4x text-muted mb-3"></i>
            <p class="text-muted">Peta interaktif akan ditampilkan di sini</p>
            <small class="text-muted">(Integrasi Google Maps dapat ditambahkan)</small>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
