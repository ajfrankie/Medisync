<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Appointment;
use Carbon\Carbon;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'next_appointment_date' => 'nullable|date|after_or_equal:appointment_date',
            'status' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'The selected patient does not exist.',
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_time.required' => 'Appointment time is required.',
            'appointment_time.date_format' => 'Please use a valid time format (HH:MM).',
            'next_appointment_date.after_or_equal' => 'Next appointment must be the same or after this appointment.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $appointmentDate = Carbon::parse($this->appointment_date)->toDateString();
            $appointmentTime = Carbon::parse($this->appointment_time)->format('H:i:s');

            // Detect current appointment ID dynamically (supports {id} or {appointment})
            $appointmentId = $this->route('appointment') ?? $this->route('id');

            $exists = Appointment::where('doctor_id', $this->doctor_id)
                ->where('appointment_date', $appointmentDate)
                ->where('appointment_time', $appointmentTime)
                ->when($appointmentId, function ($query, $appointmentId) {
                    $query->where('id', '!=', $appointmentId);
                })
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'appointment_time',
                    'This doctor already has another appointment at the same date and time.'
                );
            }
        });
    }
}
