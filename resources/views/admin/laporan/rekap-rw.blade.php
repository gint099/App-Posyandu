@extends('layouts.dashboard')

@section('title', 'Rekap per RW')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-chart-bar"></i> Rekap Data per RW</h2>
        <p class="text-muted">Monitoring data pasien dan kegiatan per RW</p>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-hospital fa-2x text-primary mb-2"></i>
                    <h3>{{ $rekap->count() }}</h3>
                    <p class="text-muted mb-0">Total Posyandu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h3>{{ $rekap->sum('pasiens_count') }}</h3>
                    <p class="text-muted mb-0">Total Pasien</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-male fa-2x text-info mb-2"></i>
                    <h3>{{ $rekap->sum('pasien_laki') }}</h3>
                    <p class="text-muted mb-0">Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-pink">
                <div class="card-body text-center">
                    <i class="fas fa-female fa-2x text-pink mb-2"></i>
                    <h3>{{ $rekap->sum('pasien_perempuan') }}</h3>
                    <p class="text-muted mb-0">Perempuan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekap per RW -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Rekap Detail per RW</h5>
        </div>
        <div class="card-body">
            @if($rekap->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">RW</th>
                                <th>Nama Posyandu</th>
                                <th>Alamat</th>
                                <th>Ketua</th>
                                <th class="text-center">Total Pasien</th>
                                <th class="text-center">Laki-laki</th>
                                <th class="text-center">Perempuan</th>
                                <th class="text-center">Pemeriksaan<br>Bulan Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekap as $r)
                                <tr>
                                    <td class="text-center"><strong>{{ $r->rw }}</strong></td>
                                    <td>{{ $r->nama_posyandu }}</td>
                                    <td>{{ $r->alamat }}</td>
                                    <td>{{ $r->ketua ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $r->pasiens_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $r->pasien_laki }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-pink">{{ $r->pasien_perempuan }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $pemeriksaanCount = $r->pasiens->sum(function($pasien) {
                                                return $pasien->pemeriksaans->count();
                                            });
                                        @endphp
                                        <span class="badge bg-success">{{ $pemeriksaanCount }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">TOTAL:</th>
                                <th class="text-center">
                                    <span class="badge bg-primary">{{ $rekap->sum('pasiens_count') }}</span>
                                </th>
                                <th class="text-center">
                                    <span class="badge bg-info">{{ $rekap->sum('pasien_laki') }}</span>
                                </th>
                                <th class="text-center">
                                    <span class="badge bg-pink">{{ $rekap->sum('pasien_perempuan') }}</span>
                                </th>
                                <th class="text-center">
                                    @php
                                        $totalPemeriksaan = $rekap->sum(function($r) {
                                            return $r->pasiens->sum(function($pasien) {
                                                return $pasien->pemeriksaans->count();
                                            });
                                        });
                                    @endphp
                                    <span class="badge bg-success">{{ $totalPemeriksaan }}</span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Chart Visualisasi -->
                <div class="mt-4">
                    <h6>Grafik Distribusi Pasien per RW</h6>
                    <canvas id="chartRW" height="80"></canvas>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data posyandu</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="text-end mt-3">
        <button class="btn btn-success" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Rekap
        </button>
    </div>
@endsection

@push('styles')
<style>
    .border-pink {
        border-color: #e91e63 !important;
    }
    .text-pink {
        color: #e91e63 !important;
    }
    .bg-pink {
        background-color: #e91e63 !important;
        color: white;
    }
    @media print {
        .sidebar, .navbar-custom, .btn, .breadcrumb {
            display: none !important;
        }
        canvas {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartRW');

    const data = {
        labels: [
            @foreach($rekap as $r)
                'RW {{ $r->rw }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Pasien',
            data: [
                @foreach($rekap as $r)
                    {{ $r->pasiens_count }},
                @endforeach
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 2
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
</script>
@endpush
