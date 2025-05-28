<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JamKerja;

class JamKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $record = [
            [
                'kode_jam_kerja' => 'JK01',
                'nama_jam_kerja' => 'Reguler',
                'awal_jam_masuk' => '07:00:00',
                'jam_masuk' => '08:00:00',
                'akhir_jam_masuk' => '09:00:00',
                'jam_pulang' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        JamKerja::insert($record);
    }
}
