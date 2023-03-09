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
        Karyawan::create([
            'nik' => '123456',
            'nama_lengkap' => 'Su Jia Jie',
            'jabatan' => 'Staf SIPK',
            'no_telp' => '081122334455',
            'password' => bcrypt('123456'),
            'remember_token' => '',
        ]);
    }
}
