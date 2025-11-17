@extends('layouts.dashboard')

@section('title', 'Edit Posyandu')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-hospital-alt"></i> Edit Data Posyandu</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.posyandu.index') }}">Data Posyandu</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Posyandu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posyandu.update', $posyandu->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_posyandu" class="form-label">Nama Posyandu <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('nama_posyandu') is-invalid @enderror"
                                id="nama_posyandu"
                                name="nama_posyandu"
                                value="{{ old('nama_posyandu', $posyandu->nama_posyandu) }}"
                                required
                            >
                            @error('nama_posyandu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('rw') is-invalid @enderror"
                                    id="rw"
                                    name="rw"
                                    value="{{ old('rw', $posyandu->rw) }}"
                                    required
                                >
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('kelurahan') is-invalid @enderror"
                                    id="kelurahan"
                                    name="kelurahan"
                                    value="{{ old('kelurahan', $posyandu->kelurahan) }}"
                                    required
                                >
                                @error('kelurahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('kecamatan') is-invalid @enderror"
                                    id="kecamatan"
                                    name="kecamatan"
                                    value="{{ old('kecamatan', $posyandu->kecamatan) }}"
                                    required
                                >
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea
                                class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                rows="3"
                                required
                            >{{ old('alamat', $posyandu->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ketua" class="form-label">Nama Ketua</label>
                                <input
                                    type="text"
                                    class="form-control @error('ketua') is-invalid @enderror"
                                    id="ketua"
                                    name="ketua"
                                    value="{{ old('ketua', $posyandu->ketua) }}"
                                >
                                @error('ketua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input
                                    type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $posyandu->phone) }}"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('is_active') is-invalid @enderror"
                                id="is_active"
                                name="is_active"
                                required
                            >
                                <option value="1" {{ old('is_active', $posyandu->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $posyandu->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.posyandu.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
