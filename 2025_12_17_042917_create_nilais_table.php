<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan ke tabel Siswa (Jika siswa dihapus, nilai ikut terhapus)
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Menghubungkan ke tabel Mapel
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            
            // Kolom untuk angka nilai (misal: 80, 95)
            $table->integer('angka'); 
            
            $table->timestamps();
        });
    }
};
