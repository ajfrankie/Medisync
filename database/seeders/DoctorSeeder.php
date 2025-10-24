<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch the "Doctor" role
        $doctorRole = DB::table('roles')->where('role_name', 'Doctor')->first();

        // If the role doesn't exist, stop seeding
        if (!$doctorRole) {
            $this->command->info('Doctor role not found. Seeder skipped.');
            return;
        }

        // Get all users with the Doctor role
        $doctorUsers = DB::table('users')->where('role_id', $doctorRole->id)->get();

        // Insert a doctor record for each doctor user
        foreach ($doctorUsers as $user) {
            DB::table('doctors')->insert([
                'id' => Str::uuid(),          // Unique doctor ID
                'user_id' => $user->id,       // Link to user table
                'specialization' => $faker->randomElement([
                    'Cardiology',
                    'Pediatrics',
                    'Neurology',
                    'Dermatology',
                    'General Medicine'
                ]),
                'department' => $faker->randomElement([
                    'Outpatient',
                    'Emergency',
                    'Inpatient',
                    'Surgery'
                ]),
                'experience' => $faker->numberBetween(1, 20),
                'is_activated' => $faker->boolean(90), // 90% chance of being true
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info(count($doctorUsers) . ' doctor records created successfully.');
    }
}
