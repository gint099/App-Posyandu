@extends('layouts.dashboard')

@section('title', 'Jadwal Pelayanan')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-calendar-alt"></i> Jadwal Pelayanan Posyandu</h2>
            <p class="text-muted">Kelola jadwal pelayanan semua posyandu</p>
        </div>
        <div>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jadwal.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <select name="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="posyandu_id" class="form-select">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $p)
                                <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_posyandu }} (RW {{ $p->rw }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Jadwal -->
    <div class="card">
        <div class="card-body">
            @if($jadwals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Posyandu</th>
                                <th>Jenis Pelayanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $key => $jadwal)
                                <tr>
                                    <td>{{ $jadwals->firstItem() + $key }}</td>
                                    <td>{{ $jadwal->tanggal_pelayanan->isoFormat('D MMM Y') }}</td>
                                    <td>{{ $jadwal->tanggal_pelayanan->isoFormat('dddd') }}</td>
                                    <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                    <td>
                                        {{ $jadwal->posyandu->nama_posyandu }}
                                        <br><small class="text-muted">RW {{ $jadwal->posyandu->rw }}</small>
                                    </td>
                                    <td>{{ $jadwal->jenis_pelayanan }}</td>
                                    <td>
                                        @if($jadwal->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
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

                <div class="mt-3">
                    {{ $jadwals->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                    <p>Belum ada jadwal pelayanan</p>
                    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jadwal Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
