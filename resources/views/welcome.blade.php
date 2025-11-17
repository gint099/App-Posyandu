@extends('layouts.app')

@section('title', 'Beranda - POSYANDU')

@section('content')
<div class="container">
    <BR></BR>
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 text-center">
            <i class="fas fa-heartbeat fa-5x text-success mb-4"></i>
            <h1 class="display-4 fw-bold mb-3">SISTEM INFORMASI POSYANDU</h1>
            <p class="lead text-muted mb-5">
                Kelola data kesehatan balita dengan mudah dan terstruktur
            </p>

            <div class="mt-5">
                <a href="#" class="btn btn-outline-success btn-lg">
                    <i class="fas fa-search"></i> Cari Data Pasien (NIK)
                </a>
            </div>
<BR></BR>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-user-nurse fa-3x text-primary mb-3"></i>
                            <h4>Login Kader</h4>
                            <p class="text-muted">Akses untuk petugas posyandu</p>
                            <a href="{{ route('kader.login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login Kader
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-user-shield fa-3x text-warning mb-3"></i>
                            <h4>Login Admin</h4>
                            <p class="text-muted">Akses untuk admin kelurahan</p>
                            <a href="{{ route('admin.login') }}" class="btn btn-warning text-white">
                                <i class="fas fa-sign-in-alt"></i> Login Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
<BR></BR>
            
        </div>
    </div>
</div>
@endsection