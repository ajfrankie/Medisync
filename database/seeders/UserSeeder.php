<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get role IDs
        $roles = DB::table('roles')->pluck('id', 'role_name');

        $users = [];

        // Doctor user
        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Admin Officer'] ?? null,
            'name' => 'Dr. Franklin',
            'email' => 'franklinroswer@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => $faker->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Generate some random users for each role
        foreach (['Patient', 'Nurse', 'Admin Officer'] as $roleName) {
            for ($i = 0; $i < 30; $i++) {
                $users[] = [
                    'id' => Str::uuid(),
                    'role_id' => $roles[$roleName] ?? null,
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('users')->insert($users);
    }
}
