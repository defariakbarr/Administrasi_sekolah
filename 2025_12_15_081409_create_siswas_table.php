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
    Schema::create('siswas', function (Blueprint $table) {
        $table->id();
        $table->string('nis')->unique();
        $table->string('nama');
        // Kita ubah bagian ini agar sesuai dengan seeder
        $table->string('kelas_id'); 
        $table->string('password');
        $table->timestamps();
    });
}
};
