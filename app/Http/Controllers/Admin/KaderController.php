<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'kader')->with('posyandu');

        // Filter berdasarkan posyandu
        if ($request->has('posyandu_id') && $request->posyandu_id != '') {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $kaders = $query->orderBy('created_at', 'desc')->paginate(10);
        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.kader.index', compact('kaders', 'posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandus = Posyandu::where('is_active', true)->get();
        return view('admin.kader.create', compact('posyandus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric|min:10',
            'posyandu_id' => 'required|exists:posyandus,id',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'posyandu_id.required' => 'Posyandu wajib dipilih',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kader = new User();
        $kader->name = $request->name;
        $kader->email = $request->email;
        $kader->phone = $request->phone;
        $kader->role = 'kader';
        $kader->posyandu_id = $request->posyandu_id;
        $kader->password = Hash::make($request->password);
        $kader->save();

        return redirect()->route('admin.kader.index')
            ->with('success', 'Kader berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kader = User::where('role', 'kader')
            ->with(['posyandu', 'pemeriksaans', 'imunisasis'])
            ->findOrFail($id);

        return view('admin.kader.show', compact('kader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kader = User::where('role', 'kader')->findOrFail($id);
        $posyandus = Posyandu::where('is_active', true)->get();

        return view('admin.kader.edit', compact('kader', 'posyandus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kader = User::where('role', 'kader')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|numeric|min:10',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kader->name = $request->name;
        $kader->email = $request->email;
        $kader->phone = $request->phone;
        $kader->posyandu_id = $request->posyandu_id;
        $kader->save();

        return redirect()->route('admin.kader.index')
            ->with('success', 'Data kader berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kader = User::where('role', 'kader')->findOrFail($id);
        $nama = $kader->name;
        $kader->delete();

        return redirect()->route('admin.kader.index')
            ->with('success', "Kader {$nama} berhasil dihapus!");
    }

    /**
     * Reset password kader
     */
    public function resetPassword(Request $request, string $id)
    {
        $kader = User::where('role', 'kader')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $kader->password = Hash::make($request->new_password);
        $kader->save();

        return redirect()->route('admin.kader.show', $id)
            ->with('success', 'Password berhasil direset!');
    }
}
