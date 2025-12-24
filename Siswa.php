<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'siswas'; // Memastikan Laravel mencari tabel yang benar

    protected $fillable = [
        'nama', 
        'nis', 
        'kelas_id', 
        'password'
    ];

    // Menyembunyikan password saat data dipanggil
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke Tabel Kelas 🏫
     * Agar {{ $siswa->kelas->nama_kelas }} bisa jalan
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke Tabel Nilai 📚
     */
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    /**
     * Relasi ke Tabel Absensi 📝
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}