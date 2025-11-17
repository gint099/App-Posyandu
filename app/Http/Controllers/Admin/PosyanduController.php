<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Posyandu::withCount('pasiens');

        // Filter by RW
        if ($request->has('rw') && $request->rw != '') {
            $query->where('rw', $request->rw);
        }

        // Filter by status
        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $posyandus = $query->orderBy('rw')->paginate(10);

        // Get unique RW for filter
        $rwList = Posyandu::distinct()->pluck('rw');

        return view('admin.posyandu.index', compact('posyandus', 'rwList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posyandu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_posyandu' => 'required|string|max:255',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'ketua' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
        ], [
            'nama_posyandu.required' => 'Nama posyandu wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'kelurahan.required' => 'Kelurahan wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $posyandu = new Posyandu();
        $posyandu->nama_posyandu = $request->nama_posyandu;
        $posyandu->rw = $request->rw;
        $posyandu->kelurahan = $request->kelurahan;
        $posyandu->kecamatan = $request->kecamatan;
        $posyandu->alamat = $request->alamat;
        $posyandu->ketua = $request->ketua;
        $posyandu->phone = $request->phone;
        $posyandu->is_active = true;
        $posyandu->save();

        return redirect()->route('admin.posyandu.index')
            ->with('success', 'Posyandu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $posyandu = Posyandu::withCount('pasiens')
            ->with(['users', 'jadwals' => function ($query) {
                $query->latest('tanggal_pelayanan')->take(5);
            }])
            ->findOrFail($id);

        return view('admin.posyandu.show', compact('posyandu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $posyandu = Posyandu::findOrFail($id);
        return view('admin.posyandu.edit', compact('posyandu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $posyandu = Posyandu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_posyandu' => 'required|string|max:255',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'ketua' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $posyandu->update($request->all());

        return redirect()->route('admin.posyandu.index')
            ->with('success', 'Data posyandu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $posyandu = Posyandu::findOrFail($id);

        // Cek apakah masih ada pasien
        if ($posyandu->pasiens()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus posyandu yang masih memiliki data pasien!');
        }

        $nama = $posyandu->nama_posyandu;
        $posyandu->delete();

        return redirect()->route('admin.posyandu.index')
            ->with('success', "Posyandu {$nama} berhasil dihapus!");
    }
}
