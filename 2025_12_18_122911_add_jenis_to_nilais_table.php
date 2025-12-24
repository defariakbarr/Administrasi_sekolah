<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {   
    Schema::table('nilais', function (Blueprint $table) {
        // Kita menambahkan kolom 'jenis' bertipe string
        // Kita letakkan setelah kolom 'angka' agar urutannya rapi
        $table->string('jenis')->after('angka')->nullable(); 
    });
    }

public function down()
    {
    Schema::table('nilais', function (Blueprint $table) {
        // Ini adalah tombol "undo" untuk menghapus kolom jika migrasi dibatalkan
        $table->dropColumn('jenis');
    });
    }
};
