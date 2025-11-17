@extends('layouts.dashboard')

@section('title', 'Input Imunisasi')

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
        <h2><i class="fas fa-syringe"></i> Input Imunisasi Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pasien.index') }}">Data Pasien</a></li>
                <li class="breadcrumb-item active">Input Imunisasi</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Input Imunisasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.imunisasi.store') }}" method="POST">
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
                                    <option value="{{ $jenis }}" {{ old('jenis_imunisasi') == $jenis ? 'selected' : '' }}>
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
                                value="{{ old('tanggal_imunisasi', date('Y-m-d')) }}"
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
                                placeholder="Keterangan tambahan (opsional)"
                            >{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ isset($pasien) ? route('kader.pasien.show', $pasien->id) : route('kader.pasien.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-info text-white">
                                <i class="fas fa-save"></i> Simpan Imunisasi
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
                    <h6><i class="fas fa-info-circle"></i> Jadwal Imunisasi Dasar</h6>
                    <hr>
                    <ul class="small">
                        <li><strong>Hepatitis B:</strong> 0-7 hari</li>
                        <li><strong>BCG & Polio 1:</strong> 1 bulan</li>
                        <li><strong>DPT-HB-Hib 1 & Polio 2:</strong> 2 bulan</li>
                        <li><strong>DPT-HB-Hib 2 & Polio 3:</strong> 3 bulan</li>
                        <li><strong>DPT-HB-Hib 3 & Polio 4 & IPV:</strong> 4 bulan</li>
                        <li><strong>Campak/MR:</strong> 9 bulan</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <small><strong>Info:</strong> Pastikan imunisasi diberikan sesuai jadwal untuk perlindungan optimal.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
