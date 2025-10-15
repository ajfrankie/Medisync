<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch the Patient role
        $patientRole = DB::table('roles')->where('role_name', 'Patient')->first();

        if (!$patientRole) {
            $this->command->warn('No "Patient" role found. Run RoleSeeder first.');
            return;
        }

        // Fetch all users with that role
        $patientUsers = DB::table('users')->where('role_id', $patientRole->id)->get();

        if ($patientUsers->isEmpty()) {
            $this->command->warn('No users with "Patient" role found. Run UserSeeder first.');
            return;
        }

        foreach ($patientUsers as $user) {
            DB::table('patients')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'dob' => $faker->dateTimeBetween('-80 years', '-10 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
                'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'address' => $faker->address(),
                'emergency_contact' => $faker->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
