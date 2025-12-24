<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan kolom-kolom berikut diisi
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi (pastikan sudah ada)
    public function guru() { return $this->belongsTo(Guru::class); }
    public function mapel() { return $this->belongsTo(Mapel::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
}