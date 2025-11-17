@extends('layouts.dashboard')

@section('title', 'Detail Kader')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('dashboard-content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user-nurse"></i> Detail Kader</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kader.index') }}">Data Kader</a></li>
                    <li class="breadcrumb-item active">{{ $kader->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.kader.edit', $kader->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Info Kader -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Informasi Kader</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                        <h4 class="mt-3">{{ $kader->name }}</h4>
                        <p class="text-muted">Kader Posyandu</p>
                    </div>

                    <table class="table table-sm">
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $kader->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $kader->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Posyandu</strong></td>
                            <td>
                                @if($kader->posyandu)
                                    {{ $kader->posyandu->nama_posyandu }}<br>
                                    <small class="text-muted">RW {{ $kader->posyandu->rw }}</small>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Terdaftar</strong></td>
                            <td>{{ $kader->created_at->isoFormat('D MMMM Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Reset Password -->
            <div class="card mt-3">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fas fa-key"></i> Reset Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kader.reset-password', $kader->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input
                                type="password"
                                class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password"
                                name="new_password"
                                required
                            >
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Yakin ingin reset password kader ini?')">
                            <i class="fas fa-sync"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Aktivitas Kader -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Aktivitas Kader</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-notes-medical fa-2x text-primary mb-2"></i>
                                    <h3>{{ $kader->pemeriksaans->count() }}</h3>
                                    <p class="text-muted mb-0">Total Pemeriksaan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-syringe fa-2x text-info mb-2"></i>
                                    <h3>{{ $kader->imunisasis->count() }}</h3>
                                    <p class="text-muted mb-0">Total Imunisasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6>Pemeriksaan Terakhir</h6>
                    @if($kader->pemeriksaans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pasien</th>
                                        <th>BB (kg)</th>
                                        <th>TB (cm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kader->pemeriksaans->take(5) as $p)
                                        <tr>
                                            <td>{{ $p->tanggal_pemeriksaan->isoFormat('D MMM Y') }}</td>
                                            <td>{{ $p->pasien->nama_lengkap }}</td>
                                            <td>{{ $p->berat_badan }}</td>
                                            <td>{{ $p->tinggi_badan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada pemeriksaan yang dilakukan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
