<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel');

            // Harus merujuk ke tabel 'gurus' 👨‍🏫
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');

            // Harus merujuk ke tabel 'kelas' 🏫
            // Tipe data ini otomatis sama dengan $table->id() di tabel kelas
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mapels');
    }
};