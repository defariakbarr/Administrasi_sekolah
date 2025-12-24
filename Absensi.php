<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi data
   protected $fillable = [
        'siswa_id',
        'mapel_id',   // ✨ Tambahkan ini
        'tanggal',    // ✨ Tambahkan ini juga karena ada di Controller
        'status',     // ✨ Tambahkan ini juga
        'keterangan', // ✨ Dan ini jika diperlukan
        'sakit',
        'izin',
        'alpha',
        'semester'
    ];

    // Relasi balik ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}