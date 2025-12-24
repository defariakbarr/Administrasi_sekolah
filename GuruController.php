<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        // 1. Ambil ID guru yang sedang login
        $id_guru = Auth::guard('guru')->id(); 
        
        // 2. Ambil data guru beserta relasi Mapel dan Kelas Wali
        $guru = Guru::with(['mapels', 'kelasWali'])->find($id_guru);

        // 3. Definisikan variabel pendukung secara eksplisit
        // Ini untuk mengatasi error "Undefined variable" di Blade
        $kelasWali = $guru->kelasWali; 
        $mapels = $guru->mapels; // VARIABEL INI YANG DIBUTUHKAN DI BARIS 59

        // 4. Ambil jadwal mengajar dan urutkan berdasarkan jam
        $jadwal_saya = Jadwal::with(['mapel', 'kelas'])
            ->where('guru_id', $id_guru)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        // 5. Kirim semua variabel ke view
        return view('guru.dashboard', compact('guru', 'kelasWali', 'mapels', 'jadwal_saya'));
    }
}