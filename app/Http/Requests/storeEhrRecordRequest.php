<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEhrRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        // Make sure user exists, has a role, and role_name is 'doctor'
        return $user && $user->role_id === '1';
    }

    public function rules(): array
    {
        return [
            'patient_id'        => ['required', 'uuid', 'exists:patients,id'],
            'doctor_id'         => ['required', 'uuid', 'exists:doctors,id'], // hidden field
            'visit_date'        => ['required', 'date', 'before_or_equal:today'],
            'diagnosis'         => ['required', 'string', 'max:2000'],
            'treatment_summary' => ['nullable', 'string', 'max:3000'],
            'next_visit_date'   => ['nullable', 'date', 'after_or_equal:visit_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required'  => 'Please select a patient.',
            'patient_id.exists'    => 'Selected patient does not exist.',
            'doctor_id.required'   => 'Doctor ID is missing.',
            'doctor_id.exists'     => 'Invalid doctor selected.',
            'visit_date.required'  => 'Visit date is required.',
            'visit_date.date'      => 'Visit date must be a valid date.',
            'visit_date.before_or_equal' => 'Visit date cannot be in the future.',
            'diagnosis.required'   => 'Diagnosis is required.',
            'diagnosis.string'     => 'Diagnosis must be text.',
            'diagnosis.max'        => 'Diagnosis cannot exceed 2000 characters.',
            'treatment_summary.string' => 'Treatment summary must be text.',
            'treatment_summary.max'    => 'Treatment summary cannot exceed 3000 characters.',
            'next_visit_date.date'      => 'Next visit date must be a valid date.',
            'next_visit_date.after_or_equal' => 'Next visit date cannot be before the visit date.',
        ];
    }
}
