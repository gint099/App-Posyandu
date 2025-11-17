@extends('layouts.dashboard')

@section('title', 'Detail Pasien')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('kader.pasien.index') }}">
            <i class="fas fa-users"></i> Data Pasien
        </a>
    </li>
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user"></i> Detail Pasien</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kader.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item active">{{ $pasien->nama_lengkap }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('kader.pasien.edit', $pasien->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Pasien -->
        <div class="col-md-4 mb-4">
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
                            <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
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
                            <td>{{ $pasien->posyandu->nama_posyandu }}</td>
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

        <!-- Riwayat & Aksi -->
        <div class="col-md-8">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('kader.pemeriksaan.create', ['pasien_id' => $pasien->id]) }}"
                               class="btn btn-success w-100">
                                <i class="fas fa-plus"></i> Input Pemeriksaan Baru
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('kader.imunisasi.create', ['pasien_id' => $pasien->id]) }}"
                               class="btn btn-info w-100">
                                <i class="fas fa-syringe"></i> Input Imunisasi Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pemeriksaan -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical"></i> Riwayat Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    @if($pasien->pemeriksaans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Usia (bln)</th>
                                        <th>BB (kg)</th>
                                        <th>TB (cm)</th>
                                        <th>LK (cm)</th>
                                        <th>Status Gizi</th>
                                        <th>Aksi</th>
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
                                                    <span class="badge bg-secondary">{{ $p->status_gizi ?? '-' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('kader.pemeriksaan.edit', $p->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('kader.pemeriksaan.destroy', $p->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>Belum ada riwayat pemeriksaan</p>
                        </div>
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
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Imunisasi</th>
                                        <th>Usia (bulan)</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien->imunisasis as $i)
                                        <tr>
                                            <td>{{ $i->tanggal_imunisasi->isoFormat('D MMM Y') }}</td>
                                            <td><span class="badge bg-primary">{{ $i->jenis_imunisasi }}</span></td>
                                            <td>{{ $i->usia_bulan_saat_imunisasi }}</td>
                                            <td>{{ $i->keterangan ?? '-' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('kader.imunisasi.edit', $i->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('kader.imunisasi.destroy', $i->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>Belum ada riwayat imunisasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
