@extends('layouts.dashboard')

@section('title', 'Detail Posyandu')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-hospital"></i> Detail Posyandu</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posyandu.index') }}">Data Posyandu</a></li>
                    <li class="breadcrumb-item active">{{ $posyandu->nama_posyandu }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.posyandu.edit', $posyandu->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Info Posyandu -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Posyandu</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>{{ $posyandu->nama_posyandu }}</td>
                        </tr>
                        <tr>
                            <td><strong>RW</strong></td>
                            <td><span class="badge bg-info">{{ $posyandu->rw }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan</strong></td>
                            <td>{{ $posyandu->kelurahan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kecamatan</strong></td>
                            <td>{{ $posyandu->kecamatan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $posyandu->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ketua</strong></td>
                            <td>{{ $posyandu->ketua ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $posyandu->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if($posyandu->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Statistik -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total Pasien</span>
                            <strong>{{ $posyandu->pasiens_count }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Kader Aktif</span>
                            <strong>{{ $posyandu->users->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kader & Jadwal -->
        <div class="col-md-8">
            <!-- Daftar Kader -->
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Daftar Kader</h5>
                </div>
                <div class="card-body">
                    @if($posyandu->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posyandu->users as $kader)
                                        <tr>
                                            <td>{{ $kader->name }}</td>
                                            <td>{{ $kader->email }}</td>
                                            <td>{{ $kader->phone ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.kader.show', $kader->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada kader yang ditugaskan</p>
                        <a href="{{ route('admin.kader.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kader
                        </a>
                    @endif
                </div>
            </div>

            <!-- Jadwal Terdekat -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Jadwal Pelayanan</h5>
                    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </a>
                </div>
                <div class="card-body">
                    @if($posyandu->jadwals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Jenis Pelayanan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posyandu->jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->tanggal_pelayanan->isoFormat('D MMM Y') }}</td>
                                            <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                            <td>{{ $jadwal->jenis_pelayanan }}</td>
                                            <td>
                                                @if($jadwal->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada jadwal pelayanan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
