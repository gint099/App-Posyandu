@extends('layouts.dashboard')

@section('title', 'Detail Pasien')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-user"></i> Detail Pasien</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pasien.index') }}">Data Pasien</a></li>
                <li class="breadcrumb-item active">{{ $pasien->nama_lengkap }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Info Pasien -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Informasi Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($pasien->jenis_kelamin == 'L')
                            <i class="fas fa-male fa-5x text-info"></i>
                        @else
                            <i class="fas fa-female fa-5x" style="color: #e91e63;"></i>
                        @endif
                        <h4 class="mt-3">{{ $pasien->nama_lengkap }}</h4>
                        <p class="text-muted mb-0">NIK: {{ $pasien->nik }}</p>
                    </div>

                    <table class="table table-sm">
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat Lahir</strong></td>
                            <td>{{ $pasien->tempat_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td>{{ $pasien->tanggal_lahir->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Usia</strong></td>
                            <td><span class="badge bg-info">{{ $usiaBulan }} Bulan</span></td>
                        </tr>
                        <tr>
                            <td><strong>No. KK</strong></td>
                            <td>{{ $pasien->no_kk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Posyandu</strong></td>
                            <td>
                                {{ $pasien->posyandu->nama_posyandu }}
                                <br><small class="text-muted">RW {{ $pasien->posyandu->rw }}</small>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <h6><i class="fas fa-users"></i> Data Orang Tua</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nama Ayah</strong></td>
                            <td>{{ $pasien->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Ibu</strong></td>
                            <td>{{ $pasien->nama_ibu }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>{{ $pasien->phone_ortu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Alamat:</strong><br>{{ $pasien->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="col-md-8">
            <!-- Riwayat Pemeriksaan -->
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical"></i> Riwayat Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    @if($pasien->pemeriksaans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Usia (bln)</th>
                                        <th>BB (kg)</th>
                                        <th>TB (cm)</th>
                                        <th>LK (cm)</th>
                                        <th>Status Gizi</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien->pemeriksaans as $p)
                                        <tr>
                                            <td>{{ $p->tanggal_pemeriksaan->isoFormat('D MMM Y') }}</td>
                                            <td>{{ $p->usia_bulan }}</td>
                                            <td>{{ $p->berat_badan }}</td>
                                            <td>{{ $p->tinggi_badan }}</td>
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
                                            <td>{{ $p->user->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada riwayat pemeriksaan</p>
                    @endif
                </div>
            </div>

            <!-- Riwayat Imunisasi -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-syringe"></i> Riwayat Imunisasi</h5>
                </div>
                <div class="card-body">
                    @if($pasien->imunisasis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Imunisasi</th>
                                        <th>Usia (bulan)</th>
                                        <th>Keterangan</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien->imunisasis as $i)
                                        <tr>
                                            <td>{{ $i->tanggal_imunisasi->isoFormat('D MMM Y') }}</td>
                                            <td><span class="badge bg-primary">{{ $i->jenis_imunisasi }}</span></td>
                                            <td>{{ $i->usia_bulan_saat_imunisasi }}</td>
                                            <td>{{ $i->keterangan ?? '-' }}</td>
                                            <td>{{ $i->user->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada riwayat imunisasi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
