<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabang;

class CabangSeeder extends Seeder
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
                'kode_cabang' => 'SMA',
                'nama_cabang' => 'SMA Maitreyawira',
                'lokasi_kantor' => '1.141649,104.042440',
                'radius' => '20'
            ],
            [
                'kode_cabang' => 'UV',
                'nama_cabang' => 'Universitas Universal',
                'lokasi_kantor' => '1.141649,104.042440',
                'radius' => '20'
            ]
        ];
        Cabang::insert($record);
    }
}
