<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
// Perhatikan Namespace Admin di bawah ini:
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\AdminGuruController;
use App\Http\Controllers\Admin\AdminSiswaController;
use Illuminate\Support\Facades\Auth;

// --- 1. Login & Logout ---
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 2. Dashboard & Fitur Guru 👨‍🏫 ---
Route::middleware(['auth:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/kelola/{id}', [NilaiController::class, 'kelola'])->name('guru.kelola');
    Route::get('/rekap-wali', [NilaiController::class, 'rekapWali'])->name('guru.wali.rekap');
    Route::get('/cetak-massal', [NilaiController::class, 'cetakMassal'])->name('guru.nilai.cetak_massal');
    Route::get('/nilai/create/{id}', [NilaiController::class, 'createForGuru'])->name('guru.nilai.create');
    Route::post('/nilai/store', [NilaiController::class, 'storeForGuru'])->name('guru.nilai.store');
    Route::get('/rekap-rapot/{id}', [NilaiController::class, 'rekapRapot'])->name('guru.nilai.rapot');
    Route::get('/siswa/cetak/{id}', [NilaiController::class, 'cetakSiswa'])->name('guru.siswa.cetak');
    Route::get('/absensi/create/{id}', [NilaiController::class, 'createAbsen'])->name('guru.absensi.create');
    Route::get('/absensi/rekap/{id}', [NilaiController::class, 'rekapAbsen'])->name('guru.absensi.rekap');
    Route::post('/absensi/simpan', [NilaiController::class, 'storeAbsen'])->name('guru.absensi.store');
});

// --- 3. Dashboard Admin 🛠️ ---
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Memanggil dashboard dari AdminGuruController
    Route::get('/dashboard', [AdminGuruController::class, 'dashboard'])->name('admin.dashboard');

    // Rute Guru (Resource)
    Route::resource('guru', AdminGuruController::class)->parameters(['guru' => 'id'])->names('admin.guru');

    // Rute Siswa (Resource)
    Route::resource('siswa', AdminSiswaController::class)->names('admin.siswa');

    // Rute Jadwal (Resource)
    Route::resource('jadwal', JadwalController::class)->names('admin.jadwal');

    Route::get('/get-mapel/{guru_id}', function($guru_id) {
        $mapels = \App\Models\Mapel::where('guru_id', $guru_id)->get(['id', 'nama_mapel']);
        return response()->json($mapels);
    });
});

// --- 4. Dashboard Siswa 🎓 ---
Route::middleware(['auth:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::get('/cetak-pdf', [SiswaController::class, 'cetakPdf'])->name('siswa.cetak');
});