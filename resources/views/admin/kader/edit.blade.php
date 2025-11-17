@extends('layouts.dashboard')

@section('title', 'Edit Data Kader')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header">
        <h2><i class="fas fa-user-edit"></i> Edit Data Kader</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kader.index') }}">Data Kader</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Data Kader</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kader.update', $kader->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $kader->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $kader->email) }}"
                                    required
                                >
                                @error('email')
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
                                    value="{{ old('phone', $kader->phone) }}"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

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
                                    <option value="{{ $p->id }}" {{ old('posyandu_id', $kader->posyandu_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_posyandu }} - RW {{ $p->rw }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Untuk mengubah password, gunakan fitur "Reset Password" di halaman detail kader.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.kader.index') }}" class="btn btn-secondary">
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
