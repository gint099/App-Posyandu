@extends('layouts.dashboard')

@section('title', 'Data Pasien')

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
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kader.pemeriksaan.index') }}">
            <i class="fas fa-notes-medical"></i> Data Pemeriksaan
        </a>
    </li>
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-users"></i> Data Pasien</h2>
            <p class="text-muted">Daftar semua pasien di {{ auth()->user()->posyandu->nama_posyandu }}</p>
        </div>
        <div>
            <a href="{{ route('kader.pasien.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pasien Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('kader.pasien.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input
                                type="text"
                                class="form-control"
                                name="search"
                                placeholder="Cari NIK, Nama, atau Nama Ibu..."
                                value="{{ request('search') }}"
                            >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Pasien -->
    <div class="card">
        <div class="card-body">
            @if($pasiens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>JK</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia (Bulan)</th>
                                <th>Nama Ibu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasiens as $key => $pasien)
                                <tr>
                                    <td>{{ $pasiens->firstItem() + $key }}</td>
                                    <td>{{ $pasien->nik }}</td>
                                    <td>
                                        <strong>{{ $pasien->nama_lengkap }}</strong>
                                    </td>
                                    <td>
                                        @if($pasien->jenis_kelamin == 'L')
                                            <span class="badge bg-info">L</span>
                                        @else
                                            <span class="badge bg-pink">P</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->isoFormat('D MMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->diffInMonths(now()) }} Bulan</td>
                                    <td>{{ $pasien->nama_ibu }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('kader.pasien.show', $pasien->id) }}"
                                               class="btn btn-sm btn-info"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('kader.pasien.edit', $pasien->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kader.pasien.destroy', $pasien->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus data pasien ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $pasiens->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data pasien</p>
                    <a href="{{ route('kader.pasien.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pasien Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .bg-pink {
        background-color: #e91e63;
    }
</style>
@endpush
