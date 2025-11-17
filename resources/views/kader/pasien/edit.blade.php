@extends('layouts.dashboard')

@section('title', 'Edit Data Pasien')

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
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-user-edit"></i> Edit Data Pasien</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('kader.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pasien.index') }}">Data Pasien</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kader.pasien.show', $pasien->id) }}">{{ $pasien->nama_lengkap }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Data Pasien</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.pasien.update', $pasien->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Data Identitas -->
                        <h6 class="border-bottom pb-2 mb-3">Data Identitas</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    id="nik"
                                    name="nik"
                                    value="{{ old('nik', $pasien->nik) }}"
                                    placeholder="16 digit NIK"
                                    maxlength="16"
                                    required
                                >
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="no_kk" class="form-label">No. KK</label>
                                <input
                                    type="text"
                                    class="form-control @error('no_kk') is-invalid @enderror"
                                    id="no_kk"
                                    name="no_kk"
                                    value="{{ old('no_kk', $pasien->no_kk) }}"
                                    placeholder="16 digit Nomor KK"
                                    maxlength="16"
                                >
                                @error('no_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}"
                                placeholder="Nama lengkap balita"
                                required
                            >
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin"
                                    name="jenis_kelamin"
                                    required
                                >
                                    <option value="">Pilih...</option>
                                    <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input
                                    type="text"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempat_lahir"
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}"
                                    placeholder="Kota/Kabupaten"
                                >
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir"
                                    name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $pasien->tanggal_lahir->format('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}"
                                    required
                                >
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea
                                class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                rows="3"
                                placeholder="Alamat lengkap"
                                required
                            >{{ old('alamat', $pasien->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Orang Tua -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Data Orang Tua</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                <input
                                    type="text"
                                    class="form-control @error('nama_ayah') is-invalid @enderror"
                                    id="nama_ayah"
                                    name="nama_ayah"
                                    value="{{ old('nama_ayah', $pasien->nama_ayah) }}"
                                    placeholder="Nama lengkap ayah"
                                >
                                @error('nama_ayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_ibu" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('nama_ibu') is-invalid @enderror"
                                    id="nama_ibu"
                                    name="nama_ibu"
                                    value="{{ old('nama_ibu', $pasien->nama_ibu) }}"
                                    placeholder="Nama lengkap ibu"
                                    required
                                >
                                @error('nama_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone_ortu" class="form-label">No. HP Orang Tua</label>
                            <input
                                type="text"
                                class="form-control @error('phone_ortu') is-invalid @enderror"
                                id="phone_ortu"
                                name="phone_ortu"
                                value="{{ old('phone_ortu', $pasien->phone_ortu) }}"
                                placeholder="08xxxxxxxxxx"
                            >
                            @error('phone_ortu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kader.pasien.show', $pasien->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Update Data Pasien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
