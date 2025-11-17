@extends('layouts.dashboard')

@section('title', 'Data Pemeriksaan')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.pasien.index') }}">
            <i class="fas fa-users"></i> Data Pasien
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('kader.pemeriksaan.index') }}">
            <i class="fas fa-notes-medical"></i> Data Pemeriksaan
        </a>
    </li>
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-notes-medical"></i> Data Pemeriksaan</h2>
            <p class="text-muted">Riwayat semua pemeriksaan pasien</p>
        </div>
        <div>
            <a href="{{ route('kader.pemeriksaan.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Input Pemeriksaan Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('kader.pemeriksaan.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <select name="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-body">
            @if($pemeriksaans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pasien</th>
                                <th>Usia (bln)</th>
                                <th>BB (kg)</th>
                                <th>TB (cm)</th>
                                <th>LK (cm)</th>
                                <th>Status Gizi</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemeriksaans as $key => $p)
                                <tr>
                                    <td>{{ $pemeriksaans->firstItem() + $key }}</td>
                                    <td>{{ $p->tanggal_pemeriksaan->isoFormat('D MMM Y') }}</td>
                                    <td>
                                        <a href="{{ route('kader.pasien.show', $p->pasien_id) }}">
                                            {{ $p->pasien->nama_lengkap }}
                                        </a>
                                        <br><small class="text-muted">NIK: {{ $p->pasien->nik }}</small>
                                    </td>
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
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('kader.pemeriksaan.edit', $p->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pemeriksaans->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data pemeriksaan</p>
                </div>
            @endif
        </div>
    </div>
@endsection
