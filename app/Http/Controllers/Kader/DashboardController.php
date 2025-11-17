<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistik untuk kader berdasarkan posyandu mereka
        $totalPasien = Pasien::where('posyandu_id', $user->posyandu_id)->count();

        $totalPemeriksaanBulanIni = Pemeriksaan::whereHas('pasien', function ($query) use ($user) {
            $query->where('posyandu_id', $user->posyandu_id);
        })
            ->whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->count();

        $pemeriksaanTerbaru = Pemeriksaan::with(['pasien', 'user'])
            ->whereHas('pasien', function ($query) use ($user) {
                $query->where('posyandu_id', $user->posyandu_id);
            })
            ->latest('tanggal_pemeriksaan')
            ->take(5)
            ->get();

        return view('kader.dashboard', compact(
            'totalPasien',
            'totalPemeriksaanBulanIni',
            'pemeriksaanTerbaru'
        ));
    }
}
