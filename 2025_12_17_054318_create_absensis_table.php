<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        
        // 1. Relasi ke Siswa
        $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
        
        // 2. Relasi ke Mapel (INI YANG MENYEBABKAN ERROR KALAU HILANG)
        $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
        
        // 3. Tanggal Pertemuan
        $table->date('tanggal');
        
        // 4. Status (Hadir, Sakit, Izin, Alpha)
        $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpha']);
        
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}
};
