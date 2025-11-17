<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jadwal::with('posyandu');

        // Filter by month
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_pelayanan', $request->bulan);
        }

        // Filter by year
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_pelayanan', $request->tahun);
        } else {
            $query->whereYear('tanggal_pelayanan', date('Y'));
        }

        // Filter by posyandu
        if ($request->has('posyandu_id') && $request->posyandu_id != '') {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        $jadwals = $query->orderBy('tanggal_pelayanan', 'desc')->paginate(15);
        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.jadwal.index', compact('jadwals', 'posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandus = Posyandu::where('is_active', true)->get();
        return view('admin.jadwal.create', compact('posyandus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'posyandu_id' => 'required|exists:posyandus,id',
            'tanggal_pelayanan' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jenis_pelayanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'posyandu_id.required' => 'Posyandu wajib dipilih',
            'tanggal_pelayanan.required' => 'Tanggal pelayanan wajib diisi',
            'tanggal_pelayanan.after_or_equal' => 'Tanggal pelayanan tidak boleh kurang dari hari ini',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.after' => 'Jam selesai harus lebih dari jam mulai',
            'jenis_pelayanan.required' => 'Jenis pelayanan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jadwal = new Jadwal();
        $jadwal->posyandu_id = $request->posyandu_id;
        $jadwal->tanggal_pelayanan = $request->tanggal_pelayanan;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->jenis_pelayanan = $request->jenis_pelayanan;
        $jadwal->keterangan = $request->keterangan;
        $jadwal->is_active = true;
        $jadwal->save();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelayanan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = Jadwal::with('posyandu')->findOrFail($id);
        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.jadwal.edit', compact('jadwal', 'posyandus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'posyandu_id' => 'required|exists:posyandus,id',
            'tanggal_pelayanan' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jenis_pelayanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelayanan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelayanan berhasil dihapus!');
    }
}
