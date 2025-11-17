@extends('layouts.dashboard')

@section('title', 'Tambah Posyandu')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-hospital"></i> Tambah Posyandu Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.posyandu.index') }}">Data Posyandu</a></li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Data Posyandu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posyandu.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_posyandu" class="form-label">Nama Posyandu <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('nama_posyandu') is-invalid @enderror"
                                id="nama_posyandu"
                                name="nama_posyandu"
                                value="{{ old('nama_posyandu') }}"
                                placeholder="contoh: Posyandu Melati"
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
                                    value="{{ old('rw') }}"
                                    placeholder="01"
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
                                    value="{{ old('kelurahan') }}"
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
                                    value="{{ old('kecamatan') }}"
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
                            >{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6>Informasi Ketua (Opsional)</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ketua" class="form-label">Nama Ketua</label>
                                <input
                                    type="text"
                                    class="form-control @error('ketua') is-invalid @enderror"
                                    id="ketua"
                                    name="ketua"
                                    value="{{ old('ketua') }}"
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
                                    value="{{ old('phone') }}"
                                    placeholder="08xxxxxxxxxx"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.posyandu.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Posyandu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
