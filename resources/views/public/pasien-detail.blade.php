@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $pasien->nama_lengkap)

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.search') }}">Pencarian</a></li>
                    <li class="breadcrumb-item active">{{ $pasien->nama_lengkap }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar - Info Pasien -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Data Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($pasien->jenis_kelamin == 'L')
                            <i class="fas fa-male fa-5x text-info"></i>
                        @else
                            <i class="fas fa-female fa-5x" style="color: #e91e63;"></i>
                        @endif
                        <h4 class="mt-3 mb-1">{{ $pasien->nama_lengkap }}</h4>
                        <p class="text-muted small mb-0">NIK: {{ $pasien->nik }}</p>
                    </div>

                    <hr>

                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Jenis Kelamin</td>
                            <td class="text-end"><strong>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tempat Lahir</td>
                            <td class="text-end"><strong>{{ $pasien->tempat_lahir ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Lahir</td>
                            <td class="text-end"><strong>{{ $pasien->tanggal_lahir->isoFormat('D MMMM Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Usia</td>
                            <td class="text-end">
                                <span class="badge bg-info">{{ $usiaBulan }} Bulan</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Ibu</td>
                            <td class="text-end"><strong>{{ $pasien->nama_ibu }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Posyandu</td>
                            <td class="text-end">
                                <strong>{{ $pasien->posyandu->nama_posyandu }}</strong>
                                <br><small class="text-muted">RW {{ $pasien->posyandu->rw }}</small>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <div class="d-grid">
                        <a href="{{ route('public.search') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Cari Data Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Grafik Perkembangan -->
            @if($pasien->pemeriksaans->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-success"></i> Grafik Perkembangan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPerkembangan" height="80"></canvas>
                </div>
            </div>
            @endif

            <!-- Riwayat Pemeriksaan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical text-primary"></i> Riwayat Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    @if($pasien->pemeriksaans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Usia (bln)</th>
                                        <th>BB (kg)</th>
                                        <th>TB (cm)</th>
                                        <th>LK (cm)</th>
                                        <th>Status Gizi</th>
                                        <th>Vitamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien->pemeriksaans->sortByDesc('tanggal_pemeriksaan') as $p)
                                        <tr>
                                            <td>{{ $p->tanggal_pemeriksaan->isoFormat('D MMM Y') }}</td>
                                            <td>{{ $p->usia_bulan }}</td>
                                            <td><strong>{{ $p->berat_badan }}</strong></td>
                                            <td><strong>{{ $p->tinggi_badan }}</strong></td>
                                            <td>{{ $p->lingkar_kepala ?? '-' }}</td>
                                            <td>
                                                @if($p->status_gizi == 'Baik')
                                                    <span class="badge bg-success">{{ $p->status_gizi }}</span>
                                                @elseif($p->status_gizi == 'Kurang')
                                                    <span class="badge bg-warning">{{ $p->status_gizi }}</span>
                                                @elseif($p->status_gizi == 'Sangat Kurang')
                                                    <span class="badge bg-danger">{{ $p->status_gizi }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $p->vitamin ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Belum ada riwayat pemeriksaan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Imunisasi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-syringe text-info"></i> Riwayat Imunisasi</h5>
                </div>
                <div class="card-body">
                    @if($pasien->imunisasis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Imunisasi</th>
                                        <th>Usia (bulan)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien->imunisasis->sortByDesc('tanggal_imunisasi') as $i)
                                        <tr>
                                            <td>{{ $i->tanggal_imunisasi->isoFormat('D MMM Y') }}</td>
                                            <td><span class="badge bg-primary">{{ $i->jenis_imunisasi }}</span></td>
                                            <td>{{ $i->usia_bulan_saat_imunisasi }}</td>
                                            <td>{{ $i->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Belum ada riwayat imunisasi</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Jadwal Terdekat -->
            @if($jadwalTerdekat->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt text-warning"></i> Jadwal Posyandu Terdekat</h5>
                </div>
                <div class="card-body">
                    @foreach($jadwalTerdekat as $jadwal)
                        <div class="border-start border-primary border-4 ps-3 mb-3">
                            <h6 class="mb-1">{{ $jadwal->tanggal_pelayanan->isoFormat('dddd, D MMMM Y') }}</h6>
                            <p class="mb-1">
                                <i class="fas fa-clock"></i> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                            </p>
                            <p class="mb-0">
                                <span class="badge bg-info">{{ $jadwal->jenis_pelayanan }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($pasien->pemeriksaans->count() > 0)
    const ctx = document.getElementById('chartPerkembangan');

    const data = {
        labels: {!! json_encode($grafikLabel) !!},
        datasets: [
            {
                label: 'Berat Badan (kg)',
                data: {!! json_encode($grafikBB) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Tinggi Badan (cm)',
                data: {!! json_encode($grafikTB) !!},
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.3,
                fill: true
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Perkembangan Berat & Tinggi Badan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);
    @endif
</script>
@endpush
