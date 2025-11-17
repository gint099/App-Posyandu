<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POSYANDU')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #2196F3;
            --success-color: #8BC34A;
            --danger-color: #f44336;
            --warning-color: #FF9800;
            --info-color: #00BCD4;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, #45a049 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .stats-card {
            padding: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Public Navbar */
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link {
            margin: 0 10px;
            color: #333 !important;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Public Navbar (hanya muncul jika bukan dashboard) -->
    @if(!request()->routeIs('kader.*') && !request()->routeIs('admin.*'))
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-heartbeat"></i> POSYANDU
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.search') ? 'active' : '' }}" href="{{ route('public.search') }}">
                            <i class="fas fa-search"></i> Cari Pasien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.jadwal') ? 'active' : '' }}" href="{{ route('public.jadwal') }}">
                            <i class="fas fa-calendar-alt"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.posyandu') ? 'active' : '' }}" href="{{ route('public.posyandu') }}">
                            <i class="fas fa-hospital"></i> Posyandu
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('kader.login') }}">
                                    <i class="fas fa-user-nurse"></i> Login Kader
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.login') }}">
                                    <i class="fas fa-user-shield"></i> Login Admin
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    @yield('content')

    <!-- Footer (hanya untuk public) -->
    @if(!request()->routeIs('kader.*') && !request()->routeIs('admin.*'))
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-heartbeat"></i> POSYANDU</h5>
                    <p class="small">Sistem Informasi Posyandu untuk monitoring kesehatan balita</p>
                </div>
                <div class="col-md-3">
                    <h6>Menu</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li><a href="{{ route('public.search') }}" class="text-white-50 text-decoration-none">Cari Pasien</a></li>
                        <li><a href="{{ route('public.jadwal') }}" class="text-white-50 text-decoration-none">Jadwal</a></li>
                        <li><a href="{{ route('public.posyandu') }}" class="text-white-50 text-decoration-none">Posyandu</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Login</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('kader.login') }}" class="text-white-50 text-decoration-none">Login Kader</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-white-50 text-decoration-none">Login Admin</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-white-50">
                <p class="mb-0">&copy; {{ date('Y') }} Sistem Posyandu. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-hide alerts after 5 seconds -->
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
