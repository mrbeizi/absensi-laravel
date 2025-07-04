<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
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
                'id' => '1',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'kode_dept' => 'IT',
                'kode_cabang' => 'UV',
                'remember_token' => '',
            ],
            [
                'id' => '2',
                'name' => 'Hosea',
                'email' => 'hosea@gmail.com',
                'password' => bcrypt('123456'),
                'kode_dept' => 'IT',
                'kode_cabang' => 'UV',
                'remember_token' => '',
            ]
        ];
        User::insert($record);
    }
}
