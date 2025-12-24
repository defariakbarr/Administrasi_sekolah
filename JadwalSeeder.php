<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel jadwal lama
        DB::table('jadwals')->truncate();

        $hariKerja = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kelasIds = [1, 2, 3, 4]; // X IPA 1 sampai X IPA 4

        // PEMETAAN MANUAL SESUAI DATABASE ANDA
        // Guru ID 1 (Budi) -> Mapel ID 1 (Matematika)
        // Guru ID 2 (Ratna) -> Mapel ID 5 (Bahasa Indonesia)
        $mapping = [
            1 => 1, // Budi Santoso -> Matematika
            2 => 5, // Ratna Sari -> Bahasa Indonesia
            3 => 9, // Bambang Wijaya -> Bahasa Inggris (Contoh)
            4 => 13, // Ustadz Mansur -> Pendidikan Agama (Contoh)
        ];

        $guruIds = array_keys($mapping);
        $data = [];

        foreach ($kelasIds as $indexKelas => $kelasId) {
            foreach ($hariKerja as $indexHari => $hari) {
                
                // Rotasi guru agar tidak bentrok mengajar di dua kelas pada jam yang sama
                $guruIndex1 = ($indexKelas + $indexHari) % count($guruIds);
                $guruIndex2 = ($indexKelas + $indexHari + 1) % count($guruIds);

                $idGuru1 = $guruIds[$guruIndex1];
                $idGuru2 = $guruIds[$guruIndex2];

                // Sesi 1 (07:30 - 09:00)
                $data[] = [
                    'guru_id'     => $idGuru1,
                    'mapel_id'    => $mapping[$idGuru1], 
                    'kelas_id'    => $kelasId,
                    'hari'        => $hari,
                    'jam_mulai'   => '07:30:00',
                    'jam_selesai' => '09:00:00',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];

                // Sesi 2 (09:30 - 11:00)
                $data[] = [
                    'guru_id'     => $idGuru2,
                    'mapel_id'    => $mapping[$idGuru2],
                    'kelas_id'    => $kelasId,
                    'hari'        => $hari,
                    'jam_mulai'   => '09:30:00',
                    'jam_selesai' => '11:00:00',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        DB::table('jadwals')->insert($data);
    }
}