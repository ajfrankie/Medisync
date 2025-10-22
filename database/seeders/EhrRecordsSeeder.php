<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EhrRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EhrRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure patients and doctors exist before seeding
        $patients = Patient::all();
        $doctors = Doctor::all();

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            $this->command->warn('Skipping EHR seeding: No patients or doctors found.');
            return;
        }

        $faker = \Faker\Factory::create();

        // Number of EHR records to create
        $recordCount = 50;

        for ($i = 0; $i < $recordCount; $i++) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $visitDate = $faker->dateTimeBetween('-1 year', 'now');
            $nextVisit = $faker->boolean(50) ? Carbon::parse($visitDate)->addWeeks(rand(2, 12)) : null;

            EhrRecord::create([
                'id' => Str::uuid(),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'visit_date' => $visitDate,
                'diagnosis' => $faker->sentence(rand(6, 12)),
                'treatment_summary' => $faker->paragraph(rand(2, 4)),
                'next_visit_date' => $nextVisit,
            ]);
        }

        $this->command->info("Successfully seeded {$recordCount} EHR records.");
    }
}
