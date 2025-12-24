<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'password', // 'mapel' dihapus dari sini karena menggunakan relasi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke model Mapel
     * Menghubungkan ke tabel 'mapels' menggunakan 'guru_id'
     */
   public function mapels()
{
    // Ini akan mencari ke tabel mapels kolom guru_id yang cocok dengan id guru ini
    return $this->hasMany(Mapel::class, 'guru_id');
}

    public function kelasWali()
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }
}