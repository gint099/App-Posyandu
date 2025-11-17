@extends('layouts.dashboard')

@section('title', 'Laporan Bulanan')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-file-alt"></i> Laporan Bulanan Posyandu</h2>
        <p class="text-muted">Rekap kegiatan posyandu per bulan</p>
    </div>

    <!-- Filter Periode -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="fas fa-filter"></i> Filter Periode & Posyandu</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.bulanan') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            @for($i = date('Y'); $i >= date('Y') - 3; $i--)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Posyandu</label>
                        <select name="posyandu_id" class="form-select">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $p)
                                <option value="{{ $p->id }}" {{ $posyandu_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_posyandu }} (RW {{ $p->rw }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Periode -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Periode Laporan:</strong>
        {{ \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM') }} {{ $tahun }}
        @if($posyandu_id)
            - {{ $posyandus->find($posyandu_id)->nama_posyandu }}
        @else
            - Semua Posyandu
        @endif
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pemeriksaan</h6>
                            <h2 class="mb-0">{{ $totalPemeriksaan }}</h2>
                            <small class="text-muted">Pemeriksaan dilakukan</small>
                        </div>
                        <div>
                            <i class="fas fa-notes-medical fa-3x text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Imunisasi</h6>
                            <h2 class="mb-0">{{ $totalImunisasi }}</h2>
                            <small class="text-muted">Imunisasi diberikan</small>
                        </div>
                        <div>
                            <i class="fas fa-syringe fa-3x text-success opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Status Gizi -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Rekap Status Gizi</h5>
        </div>
        <div class="card-body">
            @if($statusGizi->count() > 0)
                <div class="row">
                    @foreach($statusGizi as $sg)
                        <div class="col-md-3 mb-3">
                            <div class="card
                                @if($sg->status_gizi == 'Baik') border-success
                                @elseif($sg->status_gizi == 'Kurang') border-warning
                                @elseif($sg->status_gizi == 'Sangat Kurang') border-danger
                                @else border-secondary
                                @endif
                            ">
                                <div class="card-body text-center">
                                    <h3 class="
                                        @if($sg->status_gizi == 'Baik') text-success
                                        @elseif($sg->status_gizi == 'Kurang') text-warning
                                        @elseif($sg->status_gizi == 'Sangat Kurang') text-danger
                                        @else text-secondary
                                        @endif
                                    ">{{ $sg->total }}</h3>
                                    <p class="mb-0">{{ $sg->status_gizi ?? 'Tidak Diketahui' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center py-3">Tidak ada data status gizi untuk periode ini</p>
            @endif
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="text-end">
        <button class="btn btn-success" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        .sidebar, .navbar-custom, .btn, .breadcrumb, .card-header {
            display: none !important;
        }
        .page-header h2 {
            font-size: 18px;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
