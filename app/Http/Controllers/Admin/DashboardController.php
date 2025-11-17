<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk admin kelurahan (semua data)
        $totalPosyandu = Posyandu::where('is_active', true)->count();
        $totalKader = User::where('role', 'kader')->count();
        $totalPasien = Pasien::count();

        $totalPemeriksaanBulanIni = Pemeriksaan::whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->count();

        // Rekap per RW
        $rekapPerRW = Posyandu::withCount('pasiens')
            ->orderBy('rw')
            ->get();

        return view('admin.dashboard', compact(
            'totalPosyandu',
            'totalKader',
            'totalPasien',
            'totalPemeriksaanBulanIni',
            'rekapPerRW'
        ));
    }
}
