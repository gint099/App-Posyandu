@extends('layouts.dashboard')

@section('title', 'Data Posyandu')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-hospital"></i> Data Posyandu</h2>
            <p class="text-muted">Manajemen data posyandu per RW</p>
        </div>
        <div>
            <a href="{{ route('admin.posyandu.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Posyandu Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.posyandu.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <select name="rw" class="form-select">
                            <option value="">Semua RW</option>
                            @foreach($rwList as $rw)
                                <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>
                                    RW {{ $rw }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="is_active" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
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

    <!-- Tabel Posyandu -->
    <div class="card">
        <div class="card-body">
            @if($posyandus->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>RW</th>
                                <th>Nama Posyandu</th>
                                <th>Alamat</th>
                                <th>Ketua</th>
                                <th>Telepon</th>
                                <th>Total Pasien</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posyandus as $p)
                                <tr>
                                    <td><strong>{{ $p->rw }}</strong></td>
                                    <td>{{ $p->nama_posyandu }}</td>
                                    <td>{{ $p->alamat }}</td>
                                    <td>{{ $p->ketua ?? '-' }}</td>
                                    <td>{{ $p->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $p->pasiens_count }} Pasien</span>
                                    </td>
                                    <td>
                                        @if($p->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.posyandu.show', $p->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.posyandu.edit', $p->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.posyandu.destroy', $p->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus posyandu ini?')">
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
                    {{ $posyandus->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data posyandu</p>
                    <a href="{{ route('admin.posyandu.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Posyandu Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
