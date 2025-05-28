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
                'nama_dept' => 'Finance'
            ],
            [
                'kode_dept' => 'HRD',
                'nama_dept' => 'Human Resource Development'
            ],
            [
                'kode_dept' => 'IT',
                'nama_dept' => 'Information Technology'
            ],
            [
                'kode_dept' => 'WRH',
                'nama_dept' => 'Warehouse'
            ]
        ];
        Department::insert($record);
    }
}
