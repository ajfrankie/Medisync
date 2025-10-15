<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow access; use policies if you want to restrict
    }

    public function rules(): array
    {
        $userId = $this->route('doctor')?->user_id; // Get current doctor's user_id for unique email rule

        return [
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],

            // Doctor fields
            'specialization' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'experience' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            // User field messages
            'name.required' => 'Doctor name is required.',
            'name.string' => 'Doctor name must be a valid string.',
            'name.max' => 'Doctor name cannot exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email is already in use.',

            'password.min' => 'Password must be at least 6 characters long.',

            'phone.string' => 'Phone number must be a valid string.',
            'phone.max' => 'Phone cannot exceed 20 characters.',

            // Doctor field messages
            'specialization.required' => 'Specialization is required.',
            'specialization.string' => 'Specialization must be a string.',
            'specialization.max' => 'Specialization cannot exceed 255 characters.',

            'department.required' => 'Department is required.',
            'department.string' => 'Department must be a string.',
            'department.max' => 'Department cannot exceed 255 characters.',

            'experience.integer' => 'Experience must be a numeric value.',
            'experience.min' => 'Experience cannot be negative.',
        ];
    }
}
