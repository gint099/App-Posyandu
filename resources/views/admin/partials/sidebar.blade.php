<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.posyandu.*') ? 'active' : '' }}" href="{{ route('admin.posyandu.index') }}">
        <i class="fas fa-hospital"></i> Data Posyandu
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.kader.*') ? 'active' : '' }}" href="{{ route('admin.kader.index') }}">
        <i class="fas fa-user-nurse"></i> Data Kader
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}" href="{{ route('admin.pasien.index') }}">
        <i class="fas fa-users"></i> Data Pasien
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">
        <i class="fas fa-calendar-alt"></i> Jadwal Pelayanan
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.laporan.bulanan') ? 'active' : '' }}" href="{{ route('admin.laporan.bulanan') }}">
        <i class="fas fa-file-alt"></i> Laporan Bulanan
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.laporan.rekap-rw') ? 'active' : '' }}" href="{{ route('admin.laporan.rekap-rw') }}">
        <i class="fas fa-chart-bar"></i> Rekap per RW
    </a>
</li>
