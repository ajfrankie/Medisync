<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch the "Nurse" role
        $nurseRole = DB::table('roles')->where('role_name', 'Nurse')->first();

        if (!$nurseRole) {
            $this->command->warn('No "Nurse" role found. Run RoleSeeder first.');
            return;
        }

        // Get all users with the Nurse role
        $nurseUsers = DB::table('users')->where('role_id', $nurseRole->id)->get();

        if ($nurseUsers->isEmpty()) {
            $this->command->warn('No users with "Nurse" role found. Run UserSeeder first.');
            return;
        }

        // Insert a nurse record for each nurse user
        foreach ($nurseUsers as $user) {
            DB::table('nurses')->insert([
                'id' => Str::uuid(),          // Unique nurse ID
                'user_id' => $user->id,       // Link to user table
                'department' => $faker->randomElement([
                    'Emergency', 'Pediatrics', 'Surgery', 'Intensive Care', 'Outpatient', 'General Ward'
                ]),
                'shift_time' => $faker->randomElement([
                    'Morning (6 AM - 2 PM)',
                    'Afternoon (2 PM - 10 PM)',
                    'Night (10 PM - 6 AM)',
                ]),
                'is_activated' => $faker->boolean(90), // 90% chance of true
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info(count($nurseUsers) . ' nurse records created successfully.');
    }
}
