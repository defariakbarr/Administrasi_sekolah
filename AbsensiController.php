<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * 1. Menampilkan Halaman Input Absensi 📝
     */
    public function create($id)
    {
        // Mencari data Mapel berdasarkan ID dari kartu yang diklik
        $mapel = Mapel::with('kelas')->findOrFail($id);

        // Mengambil siswa di kelas tersebut
        $siswas = Siswa::where('kelas_id', $mapel->kelas_id)->get();

        return view('guru.absensi.create', compact('mapel', 'siswas'));
    }

    /**
     * 2. Menyimpan Data Absensi 💾
     */
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'tanggal'  => 'required|date',
            'status'   => 'required|array', 
        ]);

        foreach ($request->status as $siswa_id => $status_kehadiran) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'mapel_id' => $request->mapel_id,
                    'tanggal'  => $request->tanggal,
                ],
                ['status' => $status_kehadiran]
            );
        }

        // Redirect kembali ke dashboard setelah sukses
        return redirect()->route('guru.dashboard')
                         ->with('success', 'Absensi berhasil disimpan! ✅');
    }

    /**
     * 3. Menampilkan Rekap Absensi 📊
     */
    public function rekap($id)
    {
        // Ambil data Mapel beserta kelasnya
        $mapel = Mapel::with('kelas')->findOrFail($id);
        
        // Ambil semua siswa di kelas tersebut
        $siswas = Siswa::where('kelas_id', $mapel->kelas_id)->get();

        // Ambil semua data absen untuk Mapel ini
        $all_absensi = Absensi::where('mapel_id', $id)->get();

        // ✨ LOGIKA BARU: Ambil daftar tanggal unik untuk header tabel
        $daftar_tanggal = $all_absensi->pluck('tanggal')->unique()->sort();

        // Kita kirim data ke view rekap
        return view('guru.absensi.rekap', compact('mapel', 'siswas', 'all_absensi', 'daftar_tanggal'));
    }    
}