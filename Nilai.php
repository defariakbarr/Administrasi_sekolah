<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';
    protected $fillable = ['siswa_id', 'mapel_id', 'angka', 'jenis'];

    // Relasi: Satu nilai dimiliki oleh SATU Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi: Satu nilai dimiliki oleh SATU Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}