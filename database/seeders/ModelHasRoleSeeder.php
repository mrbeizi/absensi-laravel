<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ModelHasRoleSeeder extends Seeder
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
                'role_id' => '1',
                'model_type' => 'App\Models\User',
                'model_id' => '1'
            ],
            [
                'role_id' => '2',
                'model_type' => 'App\Models\User',
                'model_id' => '2'
            ]
        ];
        DB::table('model_has_roles')->insert($record);
    }
}
