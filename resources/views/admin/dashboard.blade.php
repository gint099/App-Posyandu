@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-hospital"></i> Data Posyandu
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user-nurse"></i> Data Kader
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i> Data Pasien
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-calendar-alt"></i> Jadwal Pelayanan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-chart-bar"></i> Laporan & Statistik
        </a>
    </li>
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin Kelurahan</h2>
        <p class="text-muted">Monitoring Seluruh Posyandu</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card" style="border-left-color: #4CAF50;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Posyandu</h6>
                        <h2 class="mb-0">{{ $totalPosyandu }}</h2>
                        <small class="text-success"><i class="fas fa-check-circle"></i> Aktif</small>
                    </div>
                    <div>
                        <i class="fas fa-hospital fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card" style="border-left-color: #2196F3;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Kader</h6>
                        <h2 class="mb-0">{{ $totalKader }}</h2>
                        <small class="text-muted">Petugas</small>
                    </div>
                    <div>
                        <i class="fas fa-user-nurse fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card" style="border-left-color: #FF9800;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pasien</h6>
                        <h2 class="mb-0">{{ $totalPasien }}</h2>
                        <small class="text-muted">Balita terdaftar</small>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card" style="border-left-color: #9C27B0;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pemeriksaan</h6>
                        <h2 class="mb-0">{{ $totalPemeriksaanBulanIni }}</h2>
                        <small class="text-muted">Bulan ini</small>
                    </div>
                    <div>
                        <i class="fas fa-stethoscope fa-3x text-purple opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Per RW -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Rekap Per RW / Posyandu</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>RW</th>
                            <th>Nama Posyandu</th>
                            <th>Ketua</th>
                            <th>Alamat</th>
                            <th>Total Pasien</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapPerRW as $posyandu)
                            <tr>
                                <td><strong>{{ $posyandu->rw }}</strong></td>
                                <td>{{ $posyandu->nama_posyandu }}</td>
                                <td>{{ $posyandu->ketua }}</td>
                                <td>{{ $posyandu->alamat }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $posyandu->pasiens_count }} Pasien</span>
                                </td>
                                <td>
                                    @if($posyandu->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data posyandu
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection