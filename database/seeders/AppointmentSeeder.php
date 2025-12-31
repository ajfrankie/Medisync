<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::pluck('id')->toArray();
        $doctors = Doctor::pluck('id')->toArray();

        // If no patients or doctors exist, exit early
        if (empty($patients) || empty($doctors)) {
            $this->command->warn('Please seed patients and doctors before appointments.');
            return;
        }

        // Create 15 random appointments
        for ($i = 0; $i < 15; $i++) {
            $appointmentDate = Carbon::now()->addDays(rand(0, 30));
            $appointmentTime = Carbon::createFromTime(rand(8, 17), rand(0, 1) ? 0 : 30, 0);

            Appointment::create([
                'id' => Str::uuid(),
                'patient_id' => $patients[array_rand($patients)],
                'doctor_id' => $doctors[array_rand($doctors)],
                'appointment_date' => $appointmentDate->toDateString(),
                'appointment_time' => $appointmentTime->format('H:i:s'),
                'next_appointment_date' => rand(0, 1)
                    ? $appointmentDate->copy()->addDays(rand(7, 30))->toDateString()
                    : null,
                'status' => ['Pending', 'Confirmed', 'Completed', 'Cancelled', 'Next Appointment'][rand(0, 4)],
                'notes' => fake()->sentence(),
            ]);
        }

        $this->command->info('15 Appointments seeded successfully!');
    }
}
