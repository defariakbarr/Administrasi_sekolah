<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // Menampilkan halaman kelola.blade.php
    public function kelola() {
        $guru = auth()->guard('guru')->user();
        $kelasWali = $guru->kelasWali;
        $mapels = $guru->mapels;
        return view('guru.kelola', compact('kelasWali', 'mapels'));
    }

    public function createForGuru($id) {
        $mapel = Mapel::with('kelas')->findOrFail($id);
        $siswas = Siswa::where('kelas_id', $mapel->kelas_id)->get();
        return view('guru.nilai.create', compact('mapel', 'siswas'));
    }

    public function storeForGuru(Request $request) {
        foreach ($request->nilai as $siswa_id => $angka) {
            if ($angka !== null) {
                Nilai::updateOrCreate(
                    ['siswa_id' => $siswa_id, 'mapel_id' => $request->mapel_id, 'jenis' => $request->jenis],
                    ['angka' => $angka]
                );
            }
        }
        return redirect()->route('guru.dashboard')->with('success', 'Nilai disimpan!');
    }

    public function rekapRapot($id) {
    $mapel = Mapel::findOrFail($id);
    
    // Ambil semua nilai untuk mapel ini beserta data siswanya
    $nilaiGrouped = Nilai::with('siswa')
        ->where('mapel_id', $id)
        ->get()
        ->groupBy('siswa_id');

    $rekap = [];

    foreach ($nilaiGrouped as $siswaId => $nilais) {
        $siswa = $nilais->first()->siswa;

        // Pisahkan nilai berdasarkan jenisnya
        $tugas = $nilais->where('jenis', 'Tugas')->pluck('angka');
        $uts = $nilais->where('jenis', 'UTS')->first()->angka ?? 0;
        $uas = $nilais->where('jenis', 'UAS')->first()->angka ?? 0;

        // Hitung rata-rata tugas
        $rataTugas = $tugas->count() > 0 ? $tugas->avg() : 0;

        // Hitung nilai akhir (Contoh: 40% rata tugas, 30% UTS, 30% UAS)
        $nilaiAkhir = ($rataTugas * 0.4) + ($uts * 0.3) + ($uas * 0.3);

        // Masukkan ke array rekap dengan kunci yang sesuai dengan Blade
        $rekap[$siswaId] = [
            'nama_siswa' => $siswa->nama, // Kunci ini yang tadi hilang 🔑
            'rata_tugas' => round($rataTugas, 2),
            'uts'        => $uts,
            'uas'        => $uas,
            'akhir'      => round($nilaiAkhir, 2),
        ];
    }

    return view('guru.nilai.rapot', compact('rekap', 'mapel'));
    }

    public function rekapWali(Request $request) {
        $guru = auth()->guard('guru')->user();
        $kelas = Kelas::where('guru_id', $guru->id)->firstOrFail();
        $pilihanMapel = Mapel::where('kelas_id', $kelas->id)->get();
        $filterMapelId = $request->query('mapel_id', ''); 
        $siswas = Siswa::where('kelas_id', $kelas->id)->with(['nilais.mapel'])->get();
        return view('guru.nilai.rekap_kelas', compact('siswas', 'kelas', 'pilihanMapel', 'filterMapelId'));
    }

    public function cetakMassal() {
        $guru = auth()->guard('guru')->user();
        $kelas = Kelas::where('guru_id', $guru->id)->firstOrFail();
        $semuaMapel = Mapel::where('kelas_id', $kelas->id)->get();
        $siswas = Siswa::where('kelas_id', $kelas->id)->with(['nilais.mapel', 'absensis'])->get();
        return view('guru.nilai.cetak-massal', compact('kelas', 'semuaMapel', 'siswas'));
    }

    public function createAbsen($id) {
        $mapel = Mapel::with('kelas')->findOrFail($id);
        $siswas = Siswa::where('kelas_id', $mapel->kelas_id)->get();
        return view('guru.absensi.create', compact('mapel', 'siswas'));
    }

    public function storeAbsen(Request $request) {
    // 1. Ambil data dari input bernama 'status' (sesuai Blade)
    $data_absensi = $request->input('status');

    if ($data_absensi) {
        foreach ($data_absensi as $siswa_id => $status_kehadiran) {
            \App\Models\Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id, 
                    'mapel_id' => $request->mapel_id, 
                    'tanggal'  => $request->tanggal
                ],
                ['status' => $status_kehadiran]
            );
        }
    }
    
    // 2. Sekarang redirect ini pasti akan terpanggil setelah loop selesai
    return redirect()->route('guru.dashboard')->with('success', 'Absensi berhasil disimpan!');
    }

    // app/Http/Controllers/NilaiController.php

    public function rekapAbsen($id) {
    $mapel = Mapel::with('kelas')->findOrFail($id);
    
    // 1. Ambil daftar tanggal unik untuk kolom tabel 🗓️
    $daftar_tanggal = \App\Models\Absensi::where('mapel_id', $id)
                        ->select('tanggal')
                        ->distinct()
                        ->orderBy('tanggal', 'asc')
                        ->get();

    // 2. Ambil semua data absensi untuk dipetakan ke tabel 📋
    // Variabel ini yang dicari oleh file Blade kamu
    $all_absensi = \App\Models\Absensi::where('mapel_id', $id)->get();

    // 3. Ambil daftar siswa di kelas tersebut 🎓
    $siswas = \App\Models\Siswa::where('kelas_id', $mapel->kelas_id)->get();

    return view('guru.absensi.rekap', compact('mapel', 'daftar_tanggal', 'all_absensi', 'siswas'));
    }

public function cetakSiswa($id) {
    // 1. Cari data siswa berdasarkan ID yang dikirim
    $siswa = \App\Models\Siswa::with(['kelas', 'nilais.mapel', 'absensis'])->findOrFail($id);
    
    // 2. Kita ambil data nilai yang sudah dikelompokkan berdasarkan mata pelajaran
    $nilais = $siswa->nilais->groupBy('mapel_id');

    // 3. Arahkan ke view cetak (sesuaikan nama filenya jika kamu sudah punya)
    return view('guru.siswa.cetak', compact('siswa', 'nilais'));
}   
}