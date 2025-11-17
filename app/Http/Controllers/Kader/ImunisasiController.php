<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ImunisasiController extends Controller
{
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

        // Daftar jenis imunisasi
        $jenisImunisasi = [
            'Hepatitis B',
            'BCG',
            'Polio 1',
            'Polio 2',
            'Polio 3',
            'Polio 4',
            'DPT-HB-Hib 1',
            'DPT-HB-Hib 2',
            'DPT-HB-Hib 3',
            'IPV',
            'Campak/MR',
            'DPT-HB-Hib Lanjutan',
            'Campak/MR Lanjutan',
        ];

        return view('kader.imunisasi.create', compact('pasiens', 'pasien', 'jenisImunisasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pasien_id' => 'required|exists:pasiens,id',
            'jenis_imunisasi' => 'required|string|max:255',
            'tanggal_imunisasi' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'pasien_id.required' => 'Pasien harus dipilih',
            'jenis_imunisasi.required' => 'Jenis imunisasi wajib dipilih',
            'tanggal_imunisasi.required' => 'Tanggal imunisasi wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hitung usia dalam bulan saat imunisasi
        $pasien = Pasien::findOrFail($request->pasien_id);
        $usiaBulan = Carbon::parse($pasien->tanggal_lahir)
            ->diffInMonths(Carbon::parse($request->tanggal_imunisasi));

        $imunisasi = new Imunisasi();
        $imunisasi->pasien_id = $request->pasien_id;
        $imunisasi->user_id = auth()->id();
        $imunisasi->jenis_imunisasi = $request->jenis_imunisasi;
        $imunisasi->tanggal_imunisasi = $request->tanggal_imunisasi;
        $imunisasi->usia_bulan_saat_imunisasi = $usiaBulan;
        $imunisasi->keterangan = $request->keterangan;
        $imunisasi->save();

        return redirect()->route('kader.pasien.show', $pasien->id)
            ->with('success', 'Data imunisasi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = auth()->user();

        $imunisasi = Imunisasi::with('pasien')
            ->whereHas('pasien', function ($q) use ($user) {
                $q->where('posyandu_id', $user->posyandu_id);
            })
            ->findOrFail($id);

        $jenisImunisasi = [
            'Hepatitis B',
            'BCG',
            'Polio 1',
            'Polio 2',
            'Polio 3',
            'Polio 4',
            'DPT-HB-Hib 1',
            'DPT-HB-Hib 2',
            'DPT-HB-Hib 3',
            'IPV',
            'Campak/MR',
            'DPT-HB-Hib Lanjutan',
            'Campak/MR Lanjutan',
        ];

        return view('kader.imunisasi.edit', compact('imunisasi', 'jenisImunisasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $imunisasi = Imunisasi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'jenis_imunisasi' => 'required|string|max:255',
            'tanggal_imunisasi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update usia bulan
        $usiaBulan = Carbon::parse($imunisasi->pasien->tanggal_lahir)
            ->diffInMonths(Carbon::parse($request->tanggal_imunisasi));

        $imunisasi->jenis_imunisasi = $request->jenis_imunisasi;
        $imunisasi->tanggal_imunisasi = $request->tanggal_imunisasi;
        $imunisasi->usia_bulan_saat_imunisasi = $usiaBulan;
        $imunisasi->keterangan = $request->keterangan;
        $imunisasi->save();

        return redirect()->route('kader.pasien.show', $imunisasi->pasien_id)
            ->with('success', 'Data imunisasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $pasien_id = $imunisasi->pasien_id;
        $imunisasi->delete();

        return redirect()->route('kader.pasien.show', $pasien_id)
            ->with('success', 'Data imunisasi berhasil dihapus!');
    }
}
