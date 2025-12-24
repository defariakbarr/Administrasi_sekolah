<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        // Kita tambahkan 'guru_id' untuk setiap mapel 🔗
        $mapels = [
            ['nama_mapel' => 'Matematika', 'guru_id' => 1],
            ['nama_mapel' => 'Bahasa Indonesia', 'guru_id' => 2],
            ['nama_mapel' => 'Bahasa Inggris', 'guru_id' => 3],
            ['nama_mapel' => 'Pendidikan Agama', 'guru_id' => 4],
            ['nama_mapel' => 'Pendidikan Pancasila (PPKn)', 'guru_id' => 5],
            ['nama_mapel' => 'Fisika', 'guru_id' => 6],
            ['nama_mapel' => 'Biologi', 'guru_id' => 7],
            ['nama_mapel' => 'Kimia', 'guru_id' => 8],
            ['nama_mapel' => 'Sejarah', 'guru_id' => 9],
            ['nama_mapel' => 'Geografi', 'guru_id' => 10],
            ['nama_mapel' => 'Ekonomi', 'guru_id' => 11],
            ['nama_mapel' => 'Sosiologi', 'guru_id' => 12],
            ['nama_mapel' => 'PJOK (Olahraga)', 'guru_id' => 13],
            ['nama_mapel' => 'Seni Budaya', 'guru_id' => 14],
            ['nama_mapel' => 'Informatika', 'guru_id' => 15],
            ['nama_mapel' => 'Prakarya', 'guru_id' => 16],
        ];

        foreach ($mapels as $mapel) {
            Mapel::create($mapel);
        }
    }
}