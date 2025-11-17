@extends('layouts.app')

@section('title', 'Login Admin - POSYANDU')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-warning" style="border-width: 3px;">
                <div class="card-body p-5">
                    <!-- Logo/Header -->
                    <div class="text-center mb-4">
                        <i class="fas fa-user-shield fa-4x text-warning mb-3"></i>
                        <h3 class="fw-bold">Login Admin</h3>
                        <p class="text-muted">Admin Kelurahan</p>
                    </div>

                    <!-- Error Messages -->
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

                    <!-- Login Form -->
                    <form action="{{ route('admin.login.post') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input 
                                type="email" 
                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="admin@posyandu.com"
                                autofocus
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                placeholder="******"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg text-white">
                                <i class="fas fa-sign-in-alt"></i> Login Admin
                            </button>
                        </div>
                    </form>

                    <!-- Footer Links -->
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                        <br>
                        <a href="{{ route('kader.login') }}" class="text-decoration-none mt-2 d-inline-block">
                            Login sebagai Kader
                        </a>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="alert alert-warning mt-4 mb-0">
                        <small>
                            <strong>Demo:</strong><br>
                            Email: admin@posyandu.com<br>
                            Password: admin123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection