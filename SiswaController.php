<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Jadwal; // Tambahkan ini agar bisa memanggil tabel jadwal
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil data siswa yang sedang login 🔑
        $siswa = Auth::guard('siswa')->user();

        // 2. Ambil data nilai beserta data mata pelajaran 📊
        $nilais = Nilai::with('mapel')
                    ->where('siswa_id', $siswa->id)
                    ->get();

        // 3. Ambil rekap absensi miliknya 📝
        $absensis = Absensi::where('siswa_id', $siswa->id)->get();

        // 4. Ambil Jadwal Pelajaran berdasarkan kelas siswa tersebut 📅
        $jadwal_kelas = Jadwal::with(['guru', 'mapel'])
            ->where('kelas_id', $siswa->kelas_id) // Filter berdasarkan kelas si siswa
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        // 5. Kirim semua data ke view dashboard siswa
        return view('siswa.dashboard', compact('siswa', 'nilais', 'absensis', 'jadwal_kelas'));
    }
     
    public function cetakPdf()
    {
        $siswa = Auth::guard('siswa')->user();

        $nilais = \App\Models\Nilai::where('siswa_id', $siswa->id)
                    ->with('mapel')
                    ->get();
                
        $absensis = \App\Models\Absensi::where('siswa_id', $siswa->id)->get();

        $pdf = Pdf::loadView('siswa.cetak-pdf', compact('siswa', 'nilais', 'absensis'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Rapor_' . $siswa->nama . '.pdf');
    }
}