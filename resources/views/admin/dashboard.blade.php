@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin Kelurahan</h2>
        <p class="text-muted">Monitoring Seluruh Posyandu - {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
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

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('admin.posyandu.create') }}" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-hospital-alt fa-2x mb-2"></i>
                        <br>Tambah Posyandu
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('admin.kader.create') }}" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                        <br>Tambah Kader
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-outline-info w-100 py-3">
                        <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                        <br>Buat Jadwal
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('admin.laporan.bulanan') }}" class="btn btn-outline-secondary w-100 py-3">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <br>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Per RW -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Rekap Per RW / Posyandu</h5>
            <a href="{{ route('admin.laporan.rekap-rw') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
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
                            <th class="text-center">Total Pasien</th>
                            <th class="text-center">Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapPerRW as $posyandu)
                            <tr>
                                <td><strong class="text-primary">{{ $posyandu->rw }}</strong></td>
                                <td>{{ $posyandu->nama_posyandu }}</td>
                                <td>{{ $posyandu->ketua ?? '-' }}</td>
                                <td>{{ $posyandu->alamat }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $posyandu->pasiens_count }} Pasien</span>
                                </td>
                                <td class="text-center">
                                    @if($posyandu->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.posyandu.show', $posyandu->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
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

@push('styles')
<style>
    .text-purple {
        color: #9C27B0;
    }
</style>
@endpush
