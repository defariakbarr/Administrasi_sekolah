<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $dataGuru = [
            ['nip' => '19800101', 'nama' => 'Budi Santoso, S.Pd', 'password' => Hash::make('password')],
            ['nip' => '19810202', 'nama' => 'Ratna Sari, M.Pd', 'password' => Hash::make('password')],
            ['nip' => '19820303', 'nama' => 'Bambang Wijaya, S.S', 'password' => Hash::make('password')],
            ['nip' => '19830404', 'nama' => 'Ustadz Mansur, S.Ag', 'password' => Hash::make('password')],
            ['nip' => '19840505', 'nama' => 'Drs. Hendra Gunawan', 'password' => Hash::make('password')],
            ['nip' => '19850606', 'nama' => 'Dr. Irwan Setiawan', 'password' => Hash::make('password')],
            ['nip' => '19860707', 'nama' => 'Ibu Pertiwi, M.Si', 'password' => Hash::make('password')],
            ['nip' => '19870808', 'nama' => 'Dian Sastro, S.Si', 'password' => Hash::make('password')],
            ['nip' => '19880909', 'nama' => 'Eko Prasetyo, S.Hum', 'password' => Hash::make('password')],
            ['nip' => '19891010', 'nama' => 'Mega Utami, S.Geo', 'password' => Hash::make('password')],
            ['nip' => '19901111', 'nama' => 'Randi Alam, S.E', 'password' => Hash::make('password')],
            ['nip' => '19911212', 'nama' => 'Susi Susanti, S.Sos', 'password' => Hash::make('password')],
            ['nip' => '19920113', 'nama' => 'Ade Rai, S.Pd', 'password' => Hash::make('password')],
            ['nip' => '19930214', 'nama' => 'Anggun C. Sasmi', 'password' => Hash::make('password')],
            ['nip' => '19940315', 'nama' => 'Nadiem Makarim, M.TI', 'password' => Hash::make('password')],
            ['nip' => '19950416', 'nama' => 'Bob Sadino, S.T', 'password' => Hash::make('password')],
        ];

        foreach ($dataGuru as $guru) {
            DB::table('gurus')->updateOrInsert(['nip' => $guru['nip']], [
                'nama' => $guru['nama'],
                'password' => $guru['password'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}