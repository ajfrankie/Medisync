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

        // Get role IDs
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

        // One Admin Officer
        $dob = '2001-07-21';
        $gender = 'male';
        $users[] = [
            'id' => Str::uuid(),
            'role_id' => $roles['Admin Officer'] ?? null,
            'name' => 'AJ Franklin',
            'email' => 'franklinroswer@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0774749125',
            'nic' => $generateNIC($dob, $gender),
            'dob' => $dob,
            'gender' => $gender,
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Generate random users for each role except Admin Officer
        foreach (['Patient', 'Nurse', 'Doctor'] as $roleName) {
            for ($i = 0; $i < 30; $i++) {

                // Generate a random DOB (10–80 years old)
                $dob = $faker->dateTimeBetween('-80 years', '-10 years')->format('Y-m-d');
                $gender = $faker->randomElement(['male', 'female']);

                // Generate NIC from DOB & gender
                $nic = $generateNIC($dob, $gender);

                // Generate a random phone number for each user
                $prefix = $faker->randomElement($mobilePrefixes);
                $number = $faker->numerify('#######');
                $randomContact = $prefix . $number;

                $users[] = [
                    'id' => Str::uuid(),
                    'role_id' => $roles[$roleName] ?? null,
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => Hash::make('password'),
                    'phone' => $randomContact,
                    'image_path' => null,
                    'nic' => $nic,
                    'dob' => $dob,
                    'gender' => $gender,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('users')->insert($users);
    }
}
