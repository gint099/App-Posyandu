@extends('layouts.dashboard')

@section('title', 'Edit Imunisasi')

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
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-edit"></i> Edit Data Imunisasi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pasien.show', $imunisasi->pasien_id) }}">{{ $imunisasi->pasien->nama_lengkap }}</a></li>
                <li class="breadcrumb-item active">Edit Imunisasi</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Imunisasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.imunisasi.update', $imunisasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Pasien (read-only) -->
                        <div class="alert alert-info">
                            <strong>Pasien:</strong> {{ $imunisasi->pasien->nama_lengkap }}<br>
                            <strong>NIK:</strong> {{ $imunisasi->pasien->nik }}
                        </div>

                        <!-- Jenis Imunisasi -->
                        <div class="mb-3">
                            <label for="jenis_imunisasi" class="form-label">Jenis Imunisasi <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('jenis_imunisasi') is-invalid @enderror"
                                id="jenis_imunisasi"
                                name="jenis_imunisasi"
                                required
                            >
                                <option value="">-- Pilih Jenis Imunisasi --</option>
                                @foreach($jenisImunisasi as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_imunisasi', $imunisasi->jenis_imunisasi) == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_imunisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Imunisasi -->
                        <div class="mb-3">
                            <label for="tanggal_imunisasi" class="form-label">Tanggal Imunisasi <span class="text-danger">*</span></label>
                            <input
                                type="date"
                                class="form-control @error('tanggal_imunisasi') is-invalid @enderror"
                                id="tanggal_imunisasi"
                                name="tanggal_imunisasi"
                                value="{{ old('tanggal_imunisasi', $imunisasi->tanggal_imunisasi->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                required
                            >
                            @error('tanggal_imunisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea
                                class="form-control @error('keterangan') is-invalid @enderror"
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                            >{{ old('keterangan', $imunisasi->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kader.pasien.show', $imunisasi->pasien_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Update Imunisasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
