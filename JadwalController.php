<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Guru, Mapel, Kelas};
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index() {
        $jadwals = Jadwal::with(['guru', 'mapel', 'kelas'])->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create() {
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwal.create', compact('gurus', 'mapels', 'kelas'));
    }

   public function store(Request $request)
    {
    // Cara yang lebih aman: hanya ambil kolom yang dibutuhkan
    $data = $request->only([
        'guru_id', 'mapel_id', 'kelas_id', 'hari', 'jam_mulai', 'jam_selesai'
    ]);

    \App\Models\Jadwal::create($data);

    return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil disimpan!');
    }

    public function destroy(Jadwal $jadwal) {
        $jadwal->delete();
        return back()->with('success', 'Jadwal dihapus');
    }
}