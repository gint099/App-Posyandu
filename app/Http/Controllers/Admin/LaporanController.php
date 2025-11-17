<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Laporan Bulanan
     */
    public function bulanan(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $posyandu_id = $request->get('posyandu_id', null);

        // Data Pemeriksaan
        $queryPemeriksaan = Pemeriksaan::whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun);

        if ($posyandu_id) {
            $queryPemeriksaan->whereHas('pasien', function ($q) use ($posyandu_id) {
                $q->where('posyandu_id', $posyandu_id);
            });
        }

        $totalPemeriksaan = $queryPemeriksaan->count();

        // Data Imunisasi
        $queryImunisasi = Imunisasi::whereMonth('tanggal_imunisasi', $bulan)
            ->whereYear('tanggal_imunisasi', $tahun);

        if ($posyandu_id) {
            $queryImunisasi->whereHas('pasien', function ($q) use ($posyandu_id) {
                $q->where('posyandu_id', $posyandu_id);
            });
        }

        $totalImunisasi = $queryImunisasi->count();

        // Rekap Status Gizi
        $statusGizi = Pemeriksaan::whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun)
            ->selectRaw('status_gizi, COUNT(*) as total')
            ->groupBy('status_gizi')
            ->get();

        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.laporan.bulanan', compact(
            'bulan',
            'tahun',
            'posyandu_id',
            'totalPemeriksaan',
            'totalImunisasi',
            'statusGizi',
            'posyandus'
        ));
    }

    /**
     * Rekap per RW
     */
    public function rekapRW()
    {
        $rekap = Posyandu::withCount([
            'pasiens',
            'pasiens as pasien_laki' => function ($query) {
                $query->where('jenis_kelamin', 'L');
            },
            'pasiens as pasien_perempuan' => function ($query) {
                $query->where('jenis_kelamin', 'P');
            }
        ])
            ->with(['pasiens.pemeriksaans' => function ($query) {
                $query->whereMonth('tanggal_pemeriksaan', date('m'))
                    ->whereYear('tanggal_pemeriksaan', date('Y'));
            }])
            ->orderBy('rw')
            ->get();

        return view('admin.laporan.rekap-rw', compact('rekap'));
    }
}
