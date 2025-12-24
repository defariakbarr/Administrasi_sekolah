<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class UpdateSiswaPasswordSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua data siswa
        $allSiswa = Siswa::all();

        foreach ($allSiswa as $siswa) {
            // Kita ubah passwordnya menjadi 'password123' (atau sesuaikan keinginanmu)
            // Hash::make akan mengubahnya menjadi format Bcrypt yang aman
            $siswa->update([
                'password' => Hash::make('password123') 
            ]);
        }

        $this->command->info('Semua password siswa berhasil diperbarui menjadi: password123');
    }
}