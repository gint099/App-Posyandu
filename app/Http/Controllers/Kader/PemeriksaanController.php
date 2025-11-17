<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Pemeriksaan::with(['pasien', 'user'])
            ->whereHas('pasien', function ($q) use ($user) {
                $q->where('posyandu_id', $user->posyandu_id);
            });

        // Filter bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_pemeriksaan', $request->bulan);
        }

        // Filter tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_pemeriksaan', $request->tahun);
        }

        $pemeriksaans = $query->orderBy('tanggal_pemeriksaan', 'desc')->paginate(15);

        return view('kader.pemeriksaan.index', compact('pemeriksaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        // Ambil pasien berdasarkan ID jika ada
        $pasien = null;
        if ($request->has('pasien_id')) {
            $pasien = Pasien::where('posyandu_id', $user->posyandu_id)
                ->findOrFail($request->pasien_id);
        }

        // Ambil semua pasien untuk dropdown
        $pasiens = Pasien::where('posyandu_id', $user->posyandu_id)
            ->orderBy('nama_lengkap')
            ->get();

        return view('kader.pemeriksaan.create', compact('pasiens', 'pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0|max:50',
            'tinggi_badan' => 'required|numeric|min:0|max:150',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'vitamin' => 'nullable|string|max:255',
            'status_gizi' => 'nullable|in:Sangat Kurang,Kurang,Baik,Lebih',
            'catatan' => 'nullable|string',
        ], [
            'pasien_id.required' => 'Pasien harus dipilih',
            'tanggal_pemeriksaan.required' => 'Tanggal pemeriksaan wajib diisi',
            'berat_badan.required' => 'Berat badan wajib diisi',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hitung usia dalam bulan saat pemeriksaan
        $pasien = Pasien::findOrFail($request->pasien_id);
        $usiaBulan = Carbon::parse($pasien->tanggal_lahir)
            ->diffInMonths(Carbon::parse($request->tanggal_pemeriksaan));

        $pemeriksaan = new Pemeriksaan();
        $pemeriksaan->pasien_id = $request->pasien_id;
        $pemeriksaan->user_id = auth()->id();
        $pemeriksaan->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
        $pemeriksaan->usia_bulan = $usiaBulan;
        $pemeriksaan->berat_badan = $request->berat_badan;
        $pemeriksaan->tinggi_badan = $request->tinggi_badan;
        $pemeriksaan->lingkar_kepala = $request->lingkar_kepala;
        $pemeriksaan->vitamin = $request->vitamin;
        $pemeriksaan->status_gizi = $request->status_gizi;
        $pemeriksaan->catatan = $request->catatan;
        $pemeriksaan->save();

        return redirect()->route('kader.pasien.show', $pasien->id)
            ->with('success', 'Data pemeriksaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();

        $pemeriksaan = Pemeriksaan::with(['pasien', 'user'])
            ->whereHas('pasien', function ($q) use ($user) {
                $q->where('posyandu_id', $user->posyandu_id);
            })
            ->findOrFail($id);

        return view('kader.pemeriksaan.show', compact('pemeriksaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = auth()->user();

        $pemeriksaan = Pemeriksaan::with('pasien')
            ->whereHas('pasien', function ($q) use ($user) {
                $q->where('posyandu_id', $user->posyandu_id);
            })
            ->findOrFail($id);

        return view('kader.pemeriksaan.edit', compact('pemeriksaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0|max:50',
            'tinggi_badan' => 'required|numeric|min:0|max:150',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'vitamin' => 'nullable|string|max:255',
            'status_gizi' => 'nullable|in:Sangat Kurang,Kurang,Baik,Lebih',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update usia bulan
        $usiaBulan = Carbon::parse($pemeriksaan->pasien->tanggal_lahir)
            ->diffInMonths(Carbon::parse($request->tanggal_pemeriksaan));

        $pemeriksaan->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
        $pemeriksaan->usia_bulan = $usiaBulan;
        $pemeriksaan->berat_badan = $request->berat_badan;
        $pemeriksaan->tinggi_badan = $request->tinggi_badan;
        $pemeriksaan->lingkar_kepala = $request->lingkar_kepala;
        $pemeriksaan->vitamin = $request->vitamin;
        $pemeriksaan->status_gizi = $request->status_gizi;
        $pemeriksaan->catatan = $request->catatan;
        $pemeriksaan->save();

        return redirect()->route('kader.pasien.show', $pemeriksaan->pasien_id)
            ->with('success', 'Data pemeriksaan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        $pasien_id = $pemeriksaan->pasien_id;
        $pemeriksaan->delete();

        return redirect()->route('kader.pasien.show', $pasien_id)
            ->with('success', 'Data pemeriksaan berhasil dihapus!');
    }
}
