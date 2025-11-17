@extends('layouts.dashboard')

@section('title', 'Data Kader')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user-nurse"></i> Data Kader</h2>
            <p class="text-muted">Manajemen data kader posyandu</p>
        </div>
        <div>
            <a href="{{ route('admin.kader.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kader Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kader.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Cari nama, email, atau telepon..."
                            value="{{ request('search') }}"
                        >
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
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kader -->
    <div class="card">
        <div class="card-body">
            @if($kaders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Posyandu</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kaders as $key => $kader)
                                <tr>
                                    <td>{{ $kaders->firstItem() + $key }}</td>
                                    <td>
                                        <strong>{{ $kader->name }}</strong>
                                    </td>
                                    <td>{{ $kader->email }}</td>
                                    <td>{{ $kader->phone ?? '-' }}</td>
                                    <td>
                                        @if($kader->posyandu)
                                            {{ $kader->posyandu->nama_posyandu }}
                                            <br><small class="text-muted">RW {{ $kader->posyandu->rw }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $kader->created_at->isoFormat('D MMM Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.kader.show', $kader->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kader.edit', $kader->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.kader.destroy', $kader->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus kader ini?')">
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
                    {{ $kaders->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data kader</p>
                    <a href="{{ route('admin.kader.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kader Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
