<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    
    // Pastikan guru_id dan kelas_id juga bisa diisi (fillable)
    protected $fillable = ['nama_mapel', 'guru_id', 'kelas_id'];

    /**
     * Relasi ke model Kelas 🏫
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi ke model Guru 👨‍🏫
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}