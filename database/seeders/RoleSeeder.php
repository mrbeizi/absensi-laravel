<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
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
                'name' => 'administrator',
                'guard_name' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '2',
                'name' => 'Admin Departemen',
                'guard_name' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('roles')->insert($record);
    }
}
