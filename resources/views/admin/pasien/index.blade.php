@extends('layouts.dashboard')

@section('title', 'Data Pasien')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-users"></i> Data Pasien Seluruh Posyandu</h2>
        <p class="text-muted">Monitoring data pasien dari semua posyandu</p>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pasien.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Cari NIK, Nama, atau Nama Ibu..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <select name="posyandu_id" class="form-select">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $p)
                                <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_posyandu }} (RW {{ $p->rw }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Pasien -->
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
                                <th>Posyandu</th>
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
                                        <br><small class="text-muted">Ibu: {{ $pasien->nama_ibu }}</small>
                                    </td>
                                    <td>
                                        @if($pasien->jenis_kelamin == 'L')
                                            <span class="badge bg-info">L</span>
                                        @else
                                            <span class="badge" style="background-color: #e91e63;">P</span>
                                        @endif
                                    </td>
                                    <td>{{ $pasien->tanggal_lahir->isoFormat('D MMM Y') }}</td>
                                    <td>{{ $pasien->tanggal_lahir->diffInMonths(now()) }} Bulan</td>
                                    <td>
                                        {{ $pasien->posyandu->nama_posyandu }}
                                        <br><small class="text-muted">RW {{ $pasien->posyandu->rw }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pasien.show', $pasien->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pasiens->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Tidak ada data pasien ditemukan</p>
                </div>
            @endif
        </div>
    </div>
@endsection
