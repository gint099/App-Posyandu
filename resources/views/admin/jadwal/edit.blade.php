@extends('layouts.dashboard')

@section('title', 'Edit Jadwal Pelayanan')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-calendar-edit"></i> Edit Jadwal Pelayanan</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal Pelayanan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Jadwal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="posyandu_id" class="form-label">Posyandu <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('posyandu_id') is-invalid @enderror"
                                id="posyandu_id"
                                name="posyandu_id"
                                required
                            >
                                <option value="">-- Pilih Posyandu --</option>
                                @foreach($posyandus as $p)
                                    <option value="{{ $p->id }}" {{ old('posyandu_id', $jadwal->posyandu_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_posyandu }} - RW {{ $p->rw }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pelayanan" class="form-label">Tanggal Pelayanan <span class="text-danger">*</span></label>
                            <input
                                type="date"
                                class="form-control @error('tanggal_pelayanan') is-invalid @enderror"
                                id="tanggal_pelayanan"
                                name="tanggal_pelayanan"
                                value="{{ old('tanggal_pelayanan', $jadwal->tanggal_pelayanan->format('Y-m-d')) }}"
                                required
                            >
                            @error('tanggal_pelayanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                <input
                                    type="time"
                                    class="form-control @error('jam_mulai') is-invalid @enderror"
                                    id="jam_mulai"
                                    name="jam_mulai"
                                    value="{{ old('jam_mulai', $jadwal->jam_mulai) }}"
                                    required
                                >
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                <input
                                    type="time"
                                    class="form-control @error('jam_selesai') is-invalid @enderror"
                                    id="jam_selesai"
                                    name="jam_selesai"
                                    value="{{ old('jam_selesai', $jadwal->jam_selesai) }}"
                                    required
                                >
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_pelayanan" class="form-label">Jenis Pelayanan <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('jenis_pelayanan') is-invalid @enderror"
                                id="jenis_pelayanan"
                                name="jenis_pelayanan"
                                required
                            >
                                <option value="">-- Pilih Jenis Pelayanan --</option>
                                <option value="Pemeriksaan Rutin" {{ old('jenis_pelayanan', $jadwal->jenis_pelayanan) == 'Pemeriksaan Rutin' ? 'selected' : '' }}>Pemeriksaan Rutin</option>
                                <option value="Imunisasi" {{ old('jenis_pelayanan', $jadwal->jenis_pelayanan) == 'Imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                                <option value="Pemeriksaan & Imunisasi" {{ old('jenis_pelayanan', $jadwal->jenis_pelayanan) == 'Pemeriksaan & Imunisasi' ? 'selected' : '' }}>Pemeriksaan & Imunisasi</option>
                                <option value="Penyuluhan Kesehatan" {{ old('jenis_pelayanan', $jadwal->jenis_pelayanan) == 'Penyuluhan Kesehatan' ? 'selected' : '' }}>Penyuluhan Kesehatan</option>
                                <option value="Lainnya" {{ old('jenis_pelayanan', $jadwal->jenis_pelayanan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_pelayanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea
                                class="form-control @error('keterangan') is-invalid @enderror"
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                            >{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                            <select
                                class="form-select @error('is_active') is-invalid @enderror"
                                id="is_active"
                                name="is_active"
                                required
                            >
                                <option value="1" {{ old('is_active', $jadwal->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $jadwal->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Update Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
