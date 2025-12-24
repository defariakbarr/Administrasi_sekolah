<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $daftar_kelas = ['10-A', '10-B', '11-A', '11-B', '12-A', '12-B'];

        foreach ($daftar_kelas as $nama) {
            Kelas::create(['nama_kelas' => $nama]);
        }
    }
}