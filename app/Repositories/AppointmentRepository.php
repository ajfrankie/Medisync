<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppointmentRepository
{
    protected $model;

    public function __construct(Appointment $appointment)
    {
        $this->model = $appointment;
    }

    public function get(Request $request)
    {
        $query = Appointment::orderBy('created_at', 'desc');

        if (!empty($request->doctor_id)) {
            $query->where('doctor_id', 'LIKE', "%{$request->doctor_id}%");
        }

        if (!empty($request->patient_id)) {
            $query->where('patient_id', 'LIKE', "%{$request->patient_id}%");
        }

        if (!empty($request->status)) {
            $query->where('status', 'LIKE', "%{$request->status}%");
        }

        if (!empty($request->appointment_date)) {
            $query->where('appointment_date', 'LIKE', "%{$request->appointment_date}%");
        }

        return $query;
    }

    public function create(array $input): Appointment
    {
        // Ensure required fields exist
        if (empty($input['patient_id']) || empty($input['doctor_id'])) {
            throw new \InvalidArgumentException('Both patient_id and doctor_id are required.');
        }

        $input['appointment_date'] = \Carbon\Carbon::parse($input['appointment_date'])->toDateString();
        $input['appointment_time'] = \Carbon\Carbon::parse($input['appointment_time'])->format('H:i:s');

        if (!empty($input['next_appointment_date'])) {
            $input['next_appointment_date'] = \Carbon\Carbon::parse($input['next_appointment_date'])->toDateString();
        } else {
            $input['next_appointment_date'] = null;
        }

        $input['status'] = $input['status'] ?? 'pending';
        $input['notes'] = $input['notes'] ?? null;

        // Create appointment
        $appointment = Appointment::create($input);


        $doctor = $appointment->doctor;
        $patient = $appointment->patient;

        if ($doctor && $patient) {
            Notification::create([
                'id' => Str::uuid(),
                'user_id' => $doctor->user_id,
                'appointment_id' => $appointment->id,
                'subject' => 'New Appointment Booked',
                'message' => "You have a new appointment with {$patient->name} on {$appointment->appointment_date} at {$appointment->appointment_time}.",
            ]);


            Notification::create([
                'id' => Str::uuid(),
                'user_id' => $patient->user_id,
                'appointment_id' => $appointment->id, //UUID from appointment
                'subject' => 'Appointment Confirmed',
                'message' => "Your appointment with Dr. {$doctor->name} is confirmed for {$appointment->appointment_date} at {$appointment->appointment_time}.",
            ]);
        }


        return $appointment;
    }



    public function find($id)
    {
        return Appointment::find($id);
    }

    public function update($id, array $input)
    {
        $appointment = Appointment::findOrFail($id);

        // Detect status change before saving
        $oldStatus = $appointment->status;

        if (!empty($input['appointment_date'])) {
            $input['appointment_date'] = \Carbon\Carbon::parse($input['appointment_date'])->toDateString();
        }

        if (!empty($input['appointment_time'])) {
            $input['appointment_time'] = \Carbon\Carbon::parse($input['appointment_time'])->format('H:i:s');
        }

        if (array_key_exists('next_appointment_date', $input)) {
            $input['next_appointment_date'] = !empty($input['next_appointment_date'])
                ? \Carbon\Carbon::parse($input['next_appointment_date'])->toDateString()
                : null;
        }

        // Update appointment
        $appointment->fill($input);
        $appointment->save();

        if (isset($input['status']) && $input['status'] !== $oldStatus) {
            $doctor = $appointment->doctor;
            $patient = $appointment->patient;

            if ($doctor && $patient) {
                // Doctor notification
                Notification::create([
                    'id' => Str::uuid(),
                    'user_id' => $doctor->user_id,
                    'appointment_id' => $appointment->id,
                    'subject' => 'Appointment Status Updated',
                    'message' => "The appointment with {$patient->name} has been updated to status: {$appointment->status}.",
                ]);

                // Patient notification
                Notification::create([
                    'id' => Str::uuid(),
                    'user_id' => $patient->user_id,
                    'appointment_id' => $appointment->id,
                    'subject' => 'Appointment Status Updated',
                    'message' => "Your appointment with Dr. {$doctor->name} has been updated to status: {$appointment->status}.",
                ]);
            }
        }

        return $appointment;
    }



    public function delete($id)
    {
        $appointment = $this->find($id);
        if ($appointment) {
            $appointment->delete();
        }
    }

    public function deactivate($id)
    {
        $appointment = $this->find($id);
        if ($appointment) {
            $appointment->is_activated = false;
            $appointment->save();
            return $appointment;
        }

        throw new \Exception('appointment not found');
    }

    public function activate($id)
    {
        $appointment = $this->find($id);
        if ($appointment) {
            $appointment->is_activated = true;
            $appointment->save();
            return $appointment;
        }

        throw new \Exception('appointment not found');
    }

    public function getDoctorAppointments($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)->get();
        // return Doctor::with('user')->where('user_id', $userId)->first();
    }
}
