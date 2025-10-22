<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => '1',
                'role_name' => 'Doctor',
                'description' => 'Handles patient diagnosis and treatment',
            ],
            [
                'id' => '2',
                'role_name' => 'Patient',
                'description' => 'Receives medical care and services',
            ],
            [
                'id' => '3',
                'role_name' => 'Nurse',
                'description' => 'Assists doctors and cares for patients',
            ],
            [
                'id' => '4',
                'role_name' => 'Admin Officer',
                'description' => 'Manages administrative tasks and hospital operations',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
