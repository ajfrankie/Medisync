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

        // Fetch all users with the Doctor role
        $doctorRole = DB::table('roles')->where('role_name', 'Doctor')->first();

        if (!$doctorRole) return;

        $doctorUsers = DB::table('users')->where('role_id', $doctorRole->id)->get();

        foreach ($doctorUsers as $user) {
            DB::table('doctors')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'specialization' => $faker->randomElement([
                    'Cardiology', 'Pediatrics', 'Neurology', 'Dermatology', 'General Medicine'
                ]),
                'department' => $faker->randomElement([
                    'Outpatient', 'Emergency', 'Inpatient', 'Surgery'
                ]),
                'experience' => $faker->numberBetween(1, 20),
                'is_activated' => $faker->boolean(90),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
