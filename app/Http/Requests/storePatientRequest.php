<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Adjust if you want only certain users to create patients
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'marital_status' => ['required', 'in:Single,Married,Divorced,Widowed'],
            'occupation' => ['required', 'string', 'max:255'],
            'height' => ['required', 'string', 'max:10'], // e.g., "180 cm"
            'weight' => ['required', 'string', 'max:10'], // e.g., "75 kg"
            'past_surgeries' => ['required', 'in:Yes,No'],
            'past_surgeries_details' => ['nullable', 'string', 'max:500'],
            'emergency_person' => ['required', 'string', 'max:255'],
            'preferred_language' => ['nullable', 'in:Tamil,Sinhala,English'],
            'emergency_relationship' => ['required', 'in:Father,Mother,Sibling,Spouse,Friend'],
            'emergency_contact' => ['required', 'string', 'regex:/^\+94[0-9]{9}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a patient.',
            'user_id.uuid' => 'Selected patient is invalid.',
            'user_id.exists' => 'The selected patient does not exist.',

            'blood_group.required' => 'Please select a blood group.',
            'blood_group.in' => 'Blood group must be one of: A+, A-, B+, B-, AB+, AB-, O+, O-.',

            'marital_status.required' => 'Please select marital status.',
            'marital_status.in' => 'Marital status must be Single, Married, Divorced, or Widowed.',

            'occupation.required' => 'Please enter occupation.',
            'occupation.string' => 'Occupation must be a valid text.',
            'occupation.max' => 'Occupation can be at most 255 characters.',

            'height.required' => 'Please enter height.',
            'height.string' => 'Height must be a valid text.',
            'height.max' => 'Height can be at most 10 characters.',

            'weight.required' => 'Please enter weight.',
            'weight.string' => 'Weight must be a valid text.',
            'weight.max' => 'Weight can be at most 10 characters.',

            'past_surgeries.required' => 'Please select whether patient has past surgeries.',
            'past_surgeries.in' => 'Past surgeries must be Yes or No.',

            'past_surgeries_details.string' => 'Past surgeries details must be text.',
            'past_surgeries_details.max' => 'Past surgeries details can be at most 500 characters.',

            'emergency_person.required' => 'Please enter emergency contact person name.',
            'emergency_person.string' => 'Emergency person name must be valid text.',
            'emergency_person.max' => 'Emergency person name can be at most 255 characters.',

            'preferred_language.in' => 'Preferred language must be Tamil, Sinhala, or English.',

            'emergency_relationship.required' => 'Please select emergency contact relationship.',
            'emergency_relationship.in' => 'Emergency relationship must be Father, Mother, Sibling, Spouse, or Friend.',

            'emergency_contact.required' => 'Please enter emergency contact number.',
            'emergency_contact.string' => 'Emergency contact must be valid text.',
            'emergency_contact.regex' => 'Emergency contact must be a valid Sri Lankan phone number starting with +94 followed by 9 digits.',
        ];
    }
}
