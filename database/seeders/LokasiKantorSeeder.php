<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LokasiKantorSeeder extends Seeder
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
                'id' => 1,
                'lokasi_kantor' => '1.141649,104.042440',
                'radius' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('konfigurasi_lokasis')->insert($record);
    }
}
