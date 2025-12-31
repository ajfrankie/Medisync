<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get role IDs from the roles table
        $roles = DB::table('roles')->pluck('id', 'role_name');

        $users = [];
        $mobilePrefixes = ['71', '72', '75', '76', '77', '78'];

        // Helper function to generate NIC from DOB & gender
        $generateNIC = function ($dob, $gender) {
            $date = Carbon::parse($dob);
            $year = $date->format('Y');        // full year
            $dayOfYear = $date->dayOfYear;     // 1-365/366
            if (strtolower($gender) === 'female') {
                $dayOfYear += 500; // female adjustment
            }
            $dayOfYearStr = str_pad($dayOfYear, 3, '0', STR_PAD_LEFT);
            return $year . $dayOfYearStr . '0000'; // 12-digit NIC (last 4 digits random 0000)
        };

        // --- Fixed users ---
        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Admin Officer'] ?? null,
            'name' => 'AJ Franklin',
            'email' => 'franklinroswer@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0774749120',
            'nic' => '200120303910',
            'dob' => '2001-07-21',
            'gender' => 'male',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Doctor'] ?? null,
            'name' => 'Doctor Doe',
            'email' => 'testd@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0774749121',
            'nic' => '200170304010',
            'dob' => '2001-07-21',
            'gender' => 'female',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Nurse'] ?? null,
            'name' => 'Nurse Nancy',
            'email' => 'testn@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0774749122',
            'nic' => '200170305010',
            'dob' => '2001-07-21',
            'gender' => 'female',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Patient'] ?? null,
            'name' => 'Patient Paul',
            'email' => 'testp@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0774749123',
            'nic' => '200120305201',
            'dob' => '2001-07-21',
            'gender' => 'male',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // --- Random users ---

        // Nurses (50)
        for ($i = 0; $i < 50; $i++) {
            $dob = $faker->dateTimeBetween('-65 years', '-22 years')->format('Y-m-d');
            $gender = $faker->randomElement(['male', 'female']);
            $nic = $generateNIC($dob, $gender);

            $prefix = $faker->randomElement($mobilePrefixes);
            $number = $faker->numerify('#######');

            $users[] = [
                'id' => Str::uuid(),
                'role_id' => $roles['Nurse'] ?? null,
                'name' => $faker->name($gender),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => '0' . $prefix . $number,
                'nic' => $nic,
                'dob' => $dob,
                'gender' => $gender,
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Doctors (20)
        for ($i = 0; $i < 20; $i++) {
            $dob = $faker->dateTimeBetween('-70 years', '-28 years')->format('Y-m-d');
            $gender = $faker->randomElement(['male', 'female']);
            $nic = $generateNIC($dob, $gender);

            $prefix = $faker->randomElement($mobilePrefixes);
            $number = $faker->numerify('#######');

            $users[] = [
                'id' => Str::uuid(),
                'role_id' => $roles['Doctor'] ?? null,
                'name' => $faker->name($gender),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => '0' . $prefix . $number,
                'nic' => $nic,
                'dob' => $dob,
                'gender' => $gender,
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Patients — 100 total
        // 60% Elderly (60–90 years)
        for ($i = 0; $i < 60; $i++) {
            $dob = $faker->dateTimeBetween('-90 years', '-60 years')->format('Y-m-d');
            $gender = $faker->randomElement(['male', 'female']);
            $nic = $generateNIC($dob, $gender);

            $prefix = $faker->randomElement($mobilePrefixes);
            $number = $faker->numerify('#######');

            $users[] = [
                'id' => Str::uuid(),
                'role_id' => $roles['Patient'] ?? null,
                'name' => $faker->name($gender),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => '0' . $prefix . $number,
                'nic' => $nic,
                'dob' => $dob,
                'gender' => $gender,
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 40% Non-elderly patients (18–59 years)
        for ($i = 0; $i < 40; $i++) {
            $dob = $faker->dateTimeBetween('-59 years', '-18 years')->format('Y-m-d');
            $gender = $faker->randomElement(['male', 'female']);
            $nic = $generateNIC($dob, $gender);

            $prefix = $faker->randomElement($mobilePrefixes);
            $number = $faker->numerify('#######');

            $users[] = [
                'id' => Str::uuid(),
                'role_id' => $roles['Patient'] ?? null,
                'name' => $faker->name($gender),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => '0' . $prefix . $number,
                'nic' => $nic,
                'dob' => $dob,
                'gender' => $gender,
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }


        DB::table('users')->insert($users);
    }
}
