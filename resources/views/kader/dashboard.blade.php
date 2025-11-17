@extends('layouts.dashboard')

@section('title', 'Dashboard Kader')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('kader.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.pasien.index') }}">
            <i class="fas fa-users"></i> Data Pasien
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.pemeriksaan.index') }}">
            <i class="fas fa-notes-medical"></i> Data Pemeriksaan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.pemeriksaan.create') }}">
            <i class="fas fa-plus-circle"></i> Input Pemeriksaan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.imunisasi.create') }}">
            <i class="fas fa-syringe"></i> Input Imunisasi
        </a>
    </li>
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Kader</h2>
        <p class="text-muted">Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stats-card" style="border-left-color: #4CAF50;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pasien</h6>
                        <h2 class="mb-0">{{ $totalPasien }}</h2>
                        <small class="text-muted">Pasien terdaftar</small>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card stats-card" style="border-left-color: #2196F3;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pemeriksaan Bulan Ini</h6>
                        <h2 class="mb-0">{{ $totalPemeriksaanBulanIni }}</h2>
                        <small class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}</small>
                    </div>
                    <div>
                        <i class="fas fa-stethoscope fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card stats-card" style="border-left-color: #FF9800;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Posyandu</h6>
                        <h3 class="mb-0">{{ auth()->user()->posyandu->nama_posyandu ?? '-' }}</h3>
                        <small class="text-muted">RW {{ auth()->user()->posyandu->rw ?? '-' }}</small>
                    </div>
                    <div>
                        <i class="fas fa-hospital fa-3x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                        <br>Tambah Pasien Baru
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-notes-medical fa-2x mb-2"></i>
                        <br>Input Pemeriksaan
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-outline-info w-100 py-3">
                        <i class="fas fa-syringe fa-2x mb-2"></i>
                        <br>Input Imunisasi
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-outline-secondary w-100 py-3">
                        <i class="fas fa-print fa-2x mb-2"></i>
                        <br>Cetak Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemeriksaan Terbaru -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history"></i> Pemeriksaan Terbaru</h5>
        </div>
        <div class="card-body">
            @if($pemeriksaanTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pasien</th>
                                <th>Usia (Bulan)</th>
                                <th>BB (kg)</th>
                                <th>TB (cm)</th>
                                <th>Status Gizi</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemeriksaanTerbaru as $p)
                                <tr>
                                    <td>{{ $p->tanggal_pemeriksaan->isoFormat('D MMM Y') }}</td>
                                    <td>
                                        <strong>{{ $p->pasien->nama_lengkap }}</strong>
                                        <br><small class="text-muted">NIK: {{ $p->pasien->nik }}</small>
                                    </td>
                                    <td>{{ $p->usia_bulan }}</td>
                                    <td>{{ $p->berat_badan }}</td>
                                    <td>{{ $p->tinggi_badan }}</td>
                                    <td>
                                        @if($p->status_gizi == 'Baik')
                                            <span class="badge bg-success">{{ $p->status_gizi }}</span>
                                        @elseif($p->status_gizi == 'Kurang')
                                            <span class="badge bg-warning">{{ $p->status_gizi }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $p->status_gizi ?? '-' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $p->user->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada pemeriksaan</p>
                </div>
            @endif
        </div>
    </div>
@endsection
