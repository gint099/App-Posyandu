@extends('layouts.dashboard')

@section('title', 'Edit Pemeriksaan')

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
    <div class="page-header">
        <h2><i class="fas fa-edit"></i> Edit Data Pemeriksaan</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pasien.show', $pemeriksaan->pasien_id) }}">{{ $pemeriksaan->pasien->nama_lengkap }}</a></li>
                <li class="breadcrumb-item active">Edit Pemeriksaan</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Pasien (read-only) -->
                        <div class="alert alert-info">
                            <strong>Pasien:</strong> {{ $pemeriksaan->pasien->nama_lengkap }}<br>
                            <strong>NIK:</strong> {{ $pemeriksaan->pasien->nik }}
                        </div>

                        <!-- Tanggal Pemeriksaan -->
                        <div class="mb-3">
                            <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                            <input
                                type="date"
                                class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror"
                                id="tanggal_pemeriksaan"
                                name="tanggal_pemeriksaan"
                                value="{{ old('tanggal_pemeriksaan', $pemeriksaan->tanggal_pemeriksaan->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                required
                            >
                            @error('tanggal_pemeriksaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Data Antropometri -->
                        <h6 class="mb-3"><i class="fas fa-ruler"></i> Data Antropometri</h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="berat_badan" class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('berat_badan') is-invalid @enderror"
                                    id="berat_badan"
                                    name="berat_badan"
                                    value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                                    required
                                >
                                @error('berat_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('tinggi_badan') is-invalid @enderror"
                                    id="tinggi_badan"
                                    name="tinggi_badan"
                                    value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}"
                                    required
                                >
                                @error('tinggi_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lingkar_kepala" class="form-label">Lingkar Kepala (cm)</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('lingkar_kepala') is-invalid @enderror"
                                    id="lingkar_kepala"
                                    name="lingkar_kepala"
                                    value="{{ old('lingkar_kepala', $pemeriksaan->lingkar_kepala) }}"
                                >
                                @error('lingkar_kepala')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Vitamin & Status Gizi -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vitamin" class="form-label">Vitamin</label>
                                <input
                                    type="text"
                                    class="form-control @error('vitamin') is-invalid @enderror"
                                    id="vitamin"
                                    name="vitamin"
                                    value="{{ old('vitamin', $pemeriksaan->vitamin) }}"
                                >
                                @error('vitamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status_gizi" class="form-label">Status Gizi</label>
                                <select
                                    class="form-select @error('status_gizi') is-invalid @enderror"
                                    id="status_gizi"
                                    name="status_gizi"
                                >
                                    <option value="">-- Pilih Status Gizi --</option>
                                    <option value="Sangat Kurang" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Sangat Kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                                    <option value="Kurang" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                    <option value="Baik" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Lebih" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Lebih' ? 'selected' : '' }}>Lebih</option>
                                </select>
                                @error('status_gizi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea
                                class="form-control @error('catatan') is-invalid @enderror"
                                id="catatan"
                                name="catatan"
                                rows="3"
                            >{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kader.pasien.show', $pemeriksaan->pasien_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Update Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
