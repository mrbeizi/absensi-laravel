<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
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
                'nik' => '123456',
                'nama_lengkap' => 'Andrew',
                'jabatan' => 'Staf SIPK',
                'no_telp' => '081122334455',
                'kode_dept' => 'FIN',
                'kode_cabang' => 'SMA',
                'password' => bcrypt('123456'),
                'remember_token' => ''
            ],
            [
                'nik' => '123457',
                'nama_lengkap' => 'Beibei',
                'jabatan' => 'Staf SIPK',
                'no_telp' => '08198575',
                'kode_dept' => 'IT',
                'kode_cabang' => 'UV',
                'password' => bcrypt('123457'),
                'remember_token' => ''
            ]
        ];
        Karyawan::insert($record);
    }
}
