<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
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
                'kode_dept' => 'FIN',
                'nama_dept' => 'Finance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_dept' => 'HRD',
                'nama_dept' => 'Human Resource Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_dept' => 'IT',
                'nama_dept' => 'Information Technology',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_dept' => 'WRH',
                'nama_dept' => 'Warehouse',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Department::insert($record);
    }
}
