<?php

namespace App\Repositories;

use App\Models\Appointment;
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


        return $query;
    }

    public function create(array $input): Appointment
    {
        // Ensure required fields exist
        if (empty($input['patient_id']) || empty($input['doctor_id'])) {
            throw new \InvalidArgumentException('Both patient_id and doctor_id are required.');
        }

        $input['appointment_date'] = carbon::parse($input['appointment_date'])->toDateString();
        $input['appointment_time'] = Carbon::parse($input['appointment_time'])->format('H:i:s');

        if (!empty($input['next_appointment_date'])) {
            $input['next_appointment_date'] = Carbon::parse($input['next_appointment_date'])->toDateString();
        } else {
            $input['next_appointment_date'] = null;
        }

        $input['status'] = $input['status'] ?? 'pending';
        $input['notes'] = $input['notes'] ?? null;

        return Appointment::create($input);
    }



    public function find($id)
    {
        return Appointment::find($id);
    }

    public function update($id, array $input)
    {
        $appointment = Appointment::findOrFail($id);

        if (!empty($input['appointment_date'])) {
            $input['appointment_date'] = Carbon::parse($input['appointment_date'])->toDateString();
        }

        if (!empty($input['appointment_time'])) {
            $input['appointment_time'] = Carbon::parse($input['appointment_time'])->format('H:i:s');
        }

        if (array_key_exists('next_appointment_date', $input)) {
            $input['next_appointment_date'] = !empty($input['next_appointment_date'])
                ? Carbon::parse($input['next_appointment_date'])->toDateString()
                : null;
        }

        $appointment->fill($input);
        $appointment->save();

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
}
