@extends('layouts.dashboard')

@section('title', 'Input Pemeriksaan Baru')

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
        <h2><i class="fas fa-plus-circle"></i> Input Pemeriksaan Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pemeriksaan.index') }}">Data Pemeriksaan</a></li>
                <li class="breadcrumb-item active">Input Baru</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Input Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.pemeriksaan.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Pasien -->
                        <div class="mb-3">
                            <label for="pasien_id" class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('pasien_id') is-invalid @enderror"
                                id="pasien_id"
                                name="pasien_id"
                                required
                            >
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $p)
                                    <option value="{{ $p->id }}" {{ (old('pasien_id', $pasien->id ?? '') == $p->id) ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap }} - NIK: {{ $p->nik }} ({{ \Carbon\Carbon::parse($p->tanggal_lahir)->diffInMonths(now()) }} bulan)
                                    </option>
                                @endforeach
                            </select>
                            @error('pasien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Pemeriksaan -->
                        <div class="mb-3">
                            <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                            <input
                                type="date"
                                class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror"
                                id="tanggal_pemeriksaan"
                                name="tanggal_pemeriksaan"
                                value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}"
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
                                    value="{{ old('berat_badan') }}"
                                    placeholder="contoh: 12.5"
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
                                    value="{{ old('tinggi_badan') }}"
                                    placeholder="contoh: 85.5"
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
                                    value="{{ old('lingkar_kepala') }}"
                                    placeholder="contoh: 45.5"
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
                                    value="{{ old('vitamin') }}"
                                    placeholder="contoh: Vitamin A"
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
                                    <option value="Sangat Kurang" {{ old('status_gizi') == 'Sangat Kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                                    <option value="Kurang" {{ old('status_gizi') == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                    <option value="Baik" {{ old('status_gizi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Lebih" {{ old('status_gizi') == 'Lebih' ? 'selected' : '' }}>Lebih</option>
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
                                placeholder="Catatan tambahan (opsional)"
                            >{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kader.pemeriksaan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle"></i> Panduan Pengisian</h6>
                    <hr>
                    <ul class="small">
                        <li>Pilih pasien yang akan diperiksa</li>
                        <li>Isi tanggal pemeriksaan (maksimal hari ini)</li>
                        <li>Masukkan berat badan dalam kilogram (kg)</li>
                        <li>Masukkan tinggi badan dalam centimeter (cm)</li>
                        <li>Lingkar kepala opsional, diisi untuk bayi 0-24 bulan</li>
                        <li>Status gizi akan membantu monitoring perkembangan</li>
                    </ul>

                    <div class="alert alert-warning mt-3">
                        <small><strong>Perhatian:</strong> Pastikan data yang diinput sudah benar karena akan mempengaruhi grafik perkembangan.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
