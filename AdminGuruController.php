<?php

namespace App\Http\Controllers\Admin; // Pastikan ada sub-folder Admin

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;

class AdminGuruController extends Controller
{
    // Cukup satu fungsi index saja di sini 📋
 public function index()
{
    $gurus = \App\Models\Guru::with('mapels')->get(); 
    return view('admin.guru.index', compact('gurus'));
}

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'nip' => 'required|unique:gurus,nip',
        'nama' => 'required',
        'mapel' => 'required', // Tambahkan validasi
        'password' => 'required',
    ]);

    Guru::create([
        'nip' => $request->nip,
        'nama' => $request->nama,
        'mapel' => $request->mapel, // Pastikan ini ada
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.guru.index');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nip'  => 'required|unique:gurus,nip,'.$id,
            'nama' => 'required',
        ]);

        $data = [
            'nip' => $request->nip,
            'nama' => $request->nama,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);
        return redirect()->route('admin.guru.index');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return redirect()->route('admin.guru.index');
    }

    // Fungsi untuk menampilkan menu KARTU
    public function dashboard()
    {
    $jumlahGuru = \App\Models\Guru::count();
    $jumlahSiswa = \App\Models\Siswa::count();
    
    // Kamu juga bisa menambahkan jumlah jadwal jika ingin menampilkannya di kartu
    $jumlahJadwal = \App\Models\Jadwal::count();

    return view('admin.dashboard', compact('jumlahGuru', 'jumlahSiswa', 'jumlahJadwal'));
    }

}