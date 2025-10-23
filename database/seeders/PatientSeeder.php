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

        // Get Patient role
        $patientRole = DB::table('roles')->where('role_name', 'Patient')->first();

        if (!$patientRole) {
            $this->command->warn('No "Patient" role found. Run RoleSeeder first.');
            return;
        }

        // Get all users with Patient role
        $patientUsers = DB::table('users')->where('role_id', $patientRole->id)->get();

        if ($patientUsers->isEmpty()) {
            $this->command->warn('No users with "Patient" role found. Run UserSeeder first.');
            return;
        }

        $mobilePrefixes = ['71', '72', '75', '76', '77', '78']; 

        foreach ($patientUsers as $user) {
            $prefix = $faker->randomElement($mobilePrefixes);
            $number = $faker->numerify('#######');
            $emergencyContact = '+94' . $prefix . $number;

            DB::table('patients')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'dob' => $faker->dateTimeBetween('-80 years', '-10 years')->format('Y-m-d'),
                'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'marital_status' => $faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
                'occupation' => $faker->jobTitle(),
                'height' => $faker->numberBetween(140, 200) . ' cm',
                'weight' => $faker->numberBetween(40, 120) . ' kg',
                'past_surgeries' => $faker->boolean(30) ? 'Yes' : 'No',
                'past_surgeries_details' => $faker->sentence(),
                'emergency_person' => $faker->name(),
                'preferred_language' => $faker->randomElement(['Tamil', 'Sinhala', 'English']),
                'emergency_relationship' => $faker->randomElement(['Father', 'Mother', 'Sibling', 'Spouse', 'Friend']),
                'emergency_contact' => $emergencyContact,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
