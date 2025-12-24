<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required',
            'kelas_id' => 'required',
            'password' => 'required',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambah!');
    } // Tutup fungsi store yang benar

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nis' => 'required|unique:siswas,nis,' . $id,
        'nama' => 'required',
        'kelas_id' => 'required',
    ]);

    $siswa = Siswa::findOrFail($id);
    
    // Ambil data dasar
    $data = $request->only(['nis', 'nama', 'kelas_id']);

    // Jika password baru diisi, maka update passwordnya
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $siswa->update($data);

    return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
}

public function destroy($id)
{
    $siswa = Siswa::findOrFail($id);
    $siswa->delete();

    return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus');
}
}