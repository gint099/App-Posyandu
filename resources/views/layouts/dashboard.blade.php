@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar px-0">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <h4 class="text-white mb-0">
                        <i class="fas fa-heartbeat"></i> POSYANDU
                    </h4>
                    <small class="text-white-50">{{ strtoupper(auth()->user()->role) }}</small>
                </div>

                <ul class="nav flex-column">
                    @yield('sidebar')
                </ul>

                <div class="px-3 mt-5">
                    <div class="card bg-white bg-opacity-10 border-0 text-white">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="shrink-0">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                </div>
                                <div class="flex grow">
                                    <h6 class="mb-0 small">{{ auth()->user()->name }}</h6>
                                    <small class="text-white-50">{{ auth()->user()->email }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <!-- Top Navbar -->
            <nav class="navbar navbar-custom navbar-expand-lg sticky-top mb-4">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <span class="nav-link">
                                    <i class="far fa-calendar"></i>
                                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                                </span>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('dashboard-content')
        </main>
    </div>
</div>
@endsection
