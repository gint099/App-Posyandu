@extends('layouts.app')

@section('title', 'Cari Data Pasien')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <i class="fas fa-search fa-5x text-primary mb-3"></i>
                <h2 class="fw-bold">Cari Data Pasien</h2>
                <p class="text-muted">Masukkan NIK untuk melihat data kesehatan balita</p>
            </div>

            <!-- Alert Error -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Pencarian -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form action="{{ route('public.search.result') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nik" class="form-label">
                                <i class="fas fa-id-card"></i> Nomor Induk Kependudukan (NIK)
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg @error('nik') is-invalid @enderror"
                                id="nik"
                                name="nik"
                                placeholder="Masukkan 16 digit NIK"
                                value="{{ old('nik') }}"
                                maxlength="16"
                                autofocus
                                required
                            >
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Masukkan NIK balita sesuai KTP/Kartu Keluarga
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search"></i> Cari Data
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h6><i class="fas fa-question-circle text-info"></i> Informasi</h6>
                    <ul class="small mb-0">
                        <li>NIK adalah nomor 16 digit yang tertera di KTP atau Kartu Keluarga</li>
                        <li>Pastikan NIK yang dimasukkan sudah terdaftar di posyandu</li>
                        <li>Data yang ditampilkan adalah data resmi dari posyandu</li>
                        <li>Jika NIK tidak ditemukan, silakan hubungi kader posyandu setempat</li>
                    </ul>
                </div>
            </div>

            <!-- Contoh NIK (untuk testing) -->
            <div class="alert alert-info mt-3">
                <strong>Untuk Testing:</strong><br>
                <small>NIK: 3201012020000001 atau 3201012021000002</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-format NIK (hanya angka)
    document.getElementById('nik').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
