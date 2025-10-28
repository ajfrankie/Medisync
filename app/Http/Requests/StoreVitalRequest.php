<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Adjust this logic if you need role-based restrictions
        return true;
    }

    /**
     * Validation rules for storing a Vital record.
     */
    public function rules(): array
    {
        return [
            'ehr_id'         => ['required', 'uuid', 'exists:ehr_records,id'],
            'temperature'    => ['required', 'numeric', 'between:30,45'], // realistic human range
            'blood_pressure' => ['required', 'regex:/^\d{2,3}\/\d{2,3}$/'], // e.g. 120/80
            'pulse_rate'     => ['required', 'integer', 'between:30,200'],
            'oxygen_level'   => ['nullable', 'numeric', 'between:50,100'],
            'blood_sugar'   => ['nullable', 'numeric', 'min:50'],
            'recorded_at'    => ['nullable', 'date'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'ehr_id.required'         => 'The EHR record ID is required.',
            'ehr_id.integer'          => 'The EHR record ID must be a valid number.',
            'ehr_id.exists'           => 'The selected EHR record does not exist in the system.',

            'temperature.required'    => 'Please enter the patient’s temperature.',
            'temperature.numeric'     => 'Temperature must be a numeric value.',
            'temperature.between'     => 'Temperature must be between 30°C and 45°C.',

            'blood_pressure.required' => 'Please enter the patient’s blood pressure (e.g., 120/80).',
            'blood_pressure.regex'    => 'Blood pressure format is invalid. Use the format systolic/diastolic (e.g., 120/80).',

            'pulse_rate.required'      => 'Please enter the Pulse Rate.',
            'pulse_rate.integer'      => 'Pulse rate must be an integer value.',
            'pulse_rate.between'      => 'Pulse rate must be between 30 and 200 bpm.',

            'oxygen_level.numeric'    => 'Oxygen level must be a numeric value.',
            'oxygen_level.between'    => 'Oxygen level must be between 50% and 100%.',

            'blood_sugar.numeric' => 'Blood sugar must be a numeric value.',
            'blood_sugar.between' => 'Blood sugar min 50 mg/dL.',


            'recorded_at.date'        => 'The recorded date must be a valid date.',
        ];
    }
}
