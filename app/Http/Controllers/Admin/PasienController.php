<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of all patients
     */
    public function index(Request $request)
    {
        $query = Pasien::with('posyandu');

        // Filter by posyandu
        if ($request->has('posyandu_id') && $request->posyandu_id != '') {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        // Filter by gender
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nama_ibu', 'like', "%{$search}%");
            });
        }

        $pasiens = $query->orderBy('created_at', 'desc')->paginate(15);
        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.pasien.index', compact('pasiens', 'posyandus'));
    }

    /**
     * Display the specified patient
     */
    public function show(string $id)
    {
        $pasien = Pasien::with([
            'posyandu',
            'pemeriksaans' => function ($query) {
                $query->orderBy('tanggal_pemeriksaan', 'desc');
            },
            'imunisasis' => function ($query) {
                $query->orderBy('tanggal_imunisasi', 'desc');
            }
        ])->findOrFail($id);

        $usiaBulan = \Carbon\Carbon::parse($pasien->tanggal_lahir)->diffInMonths(now());

        return view('admin.pasien.show', compact('pasien', 'usiaBulan'));
    }
}
