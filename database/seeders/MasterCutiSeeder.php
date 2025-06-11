<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterCuti;

class MasterCutiSeeder extends Seeder
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
                'kode_cuti' => 'C01',
                'nama_cuti' => 'Tahunan',
                'jumlah_hari' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_cuti' => 'C02',
                'nama_cuti' => 'Cuti Melahirkan',
                'jumlah_hari' => 90,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_cuti' => 'C03',
                'nama_cuti' => 'Cuti Khusus',
                'jumlah_hari' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        MasterCuti::insert($record);
    }
}
