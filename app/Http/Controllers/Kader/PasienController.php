<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Pasien::where('posyandu_id', $user->posyandu_id)
            ->with('posyandu');

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nama_ibu', 'like', "%{$search}%");
            });
        }

        // Filter jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $pasiens = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('kader.pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kader.pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:pasiens,nik',
            'no_kk' => 'nullable|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'phone_ortu' => 'nullable|numeric|min:10',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'nama_ibu.required' => 'Nama ibu wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pasien = new Pasien();
        $pasien->nik = $request->nik;
        $pasien->no_kk = $request->no_kk;
        $pasien->nama_lengkap = $request->nama_lengkap;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->tanggal_lahir = $request->tanggal_lahir;
        $pasien->tempat_lahir = $request->tempat_lahir;
        $pasien->alamat = $request->alamat;
        $pasien->nama_ayah = $request->nama_ayah;
        $pasien->nama_ibu = $request->nama_ibu;
        $pasien->phone_ortu = $request->phone_ortu;
        $pasien->posyandu_id = auth()->user()->posyandu_id;
        $pasien->save();

        return redirect()->route('kader.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();

        $pasien = Pasien::where('posyandu_id', $user->posyandu_id)
            ->with(['pemeriksaans' => function($query) {
                $query->orderBy('tanggal_pemeriksaan', 'desc');
            }, 'imunisasis' => function($query) {
                $query->orderBy('tanggal_imunisasi', 'desc');
            }, 'posyandu'])
            ->findOrFail($id);

        // Hitung usia dalam bulan
        $usiaBulan = \Carbon\Carbon::parse($pasien->tanggal_lahir)->diffInMonths(now());

        return view('kader.pasien.show', compact('pasien', 'usiaBulan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = auth()->user();

        $pasien = Pasien::where('posyandu_id', $user->posyandu_id)
            ->findOrFail($id);

        return view('kader.pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();

        $pasien = Pasien::where('posyandu_id', $user->posyandu_id)
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:pasiens,nik,' . $id,
            'no_kk' => 'nullable|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'phone_ortu' => 'nullable|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pasien->update($request->all());

        return redirect()->route('kader.pasien.show', $pasien->id)
            ->with('success', 'Data pasien berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();

        $pasien = Pasien::where('posyandu_id', $user->posyandu_id)
            ->findOrFail($id);

        $nama = $pasien->nama_lengkap;
        $pasien->delete();

        return redirect()->route('kader.pasien.index')
            ->with('success', "Data pasien {$nama} berhasil dihapus!");
    }
}
