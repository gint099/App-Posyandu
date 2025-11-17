<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        // Jadwal terdekat (7 hari ke depan)
        $jadwalTerdekat = Jadwal::where('is_active', true)
            ->where('tanggal_pelayanan', '>=', now())
            ->where('tanggal_pelayanan', '<=', now()->addDays(7))
            ->with('posyandu')
            ->orderBy('tanggal_pelayanan', 'asc')
            ->take(5)
            ->get();

        $totalPosyandu = Posyandu::where('is_active', true)->count();
        $totalPasien = Pasien::count();

        return view('public.index', compact('jadwalTerdekat', 'totalPosyandu', 'totalPasien'));
    }

    /**
     * Halaman pencarian
     */
    public function search()
    {
        return view('public.search');
    }

    /**
     * Proses pencarian berdasarkan NIK
     */
    public function searchResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.digits' => 'NIK harus 16 digit',
        ]);

        if ($validator->fails()) {
            return redirect()->route('public.search')
                ->withErrors($validator)
                ->withInput();
        }

        $pasien = Pasien::where('nik', $request->nik)
            ->with([
                'posyandu',
                'pemeriksaans' => function ($query) {
                    $query->orderBy('tanggal_pemeriksaan', 'desc');
                },
                'imunisasis' => function ($query) {
                    $query->orderBy('tanggal_imunisasi', 'desc');
                }
            ])
            ->first();

        if (!$pasien) {
            return redirect()->route('public.search')
                ->with('error', 'Data dengan NIK ' . $request->nik . ' tidak ditemukan!')
                ->withInput();
        }

        return redirect()->route('public.pasien.show', $pasien->id);
    }

    /**
     * Detail pasien
     */
    public function showPasien($id)
    {
        $pasien = Pasien::with([
            'posyandu',
            'pemeriksaans' => function ($query) {
                $query->orderBy('tanggal_pemeriksaan', 'asc');
            },
            'imunisasis' => function ($query) {
                $query->orderBy('tanggal_imunisasi', 'asc');
            }
        ])->findOrFail($id);

        $usiaBulan = Carbon::parse($pasien->tanggal_lahir)->diffInMonths(now());

        // Data untuk grafik perkembangan
        $grafikBB = $pasien->pemeriksaans->pluck('berat_badan')->toArray();
        $grafikTB = $pasien->pemeriksaans->pluck('tinggi_badan')->toArray();
        $grafikLabel = $pasien->pemeriksaans->pluck('tanggal_pemeriksaan')->map(function ($date) {
            return $date->isoFormat('MMM Y');
        })->toArray();

        // Jadwal posyandu terdekat
        $jadwalTerdekat = Jadwal::where('posyandu_id', $pasien->posyandu_id)
            ->where('is_active', true)
            ->where('tanggal_pelayanan', '>=', now())
            ->orderBy('tanggal_pelayanan', 'asc')
            ->take(3)
            ->get();

        return view('public.pasien-detail', compact(
            'pasien',
            'usiaBulan',
            'grafikBB',
            'grafikTB',
            'grafikLabel',
            'jadwalTerdekat'
        ));
    }

    /**
     * Daftar semua posyandu
     */
    public function posyandu()
    {
        $posyandus = Posyandu::where('is_active', true)
            ->withCount('pasiens')
            ->orderBy('rw')
            ->get();

        return view('public.posyandu', compact('posyandus'));
    }

    /**
     * Jadwal semua posyandu
     */
    public function jadwal(Request $request)
    {
        $query = Jadwal::where('is_active', true)
            ->with('posyandu');

        // Filter by bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_pelayanan', $request->bulan);
        }

        // Filter by posyandu
        if ($request->has('posyandu_id') && $request->posyandu_id != '') {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        // Default: hanya jadwal yang akan datang
        if (!$request->has('show_all')) {
            $query->where('tanggal_pelayanan', '>=', now());
        }

        $jadwals = $query->orderBy('tanggal_pelayanan', 'asc')
            ->paginate(10);

        $posyandus = Posyandu::where('is_active', true)->get();

        return view('public.jadwal', compact('jadwals', 'posyandus'));
    }
}
