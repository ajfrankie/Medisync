<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeNurseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users; adjust if needed
    }

    public function rules(): array
    {
        return [
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'], // If using password confirmation
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
            // User messages
            'name.required' => 'Nurse name is required.',
            'name.string' => 'Nurse name must be a string.',
            'name.max' => 'Nurse name cannot exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'Email is already taken.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 6 characters.',

            'phone.string' => 'Phone must be a valid string.',
            'phone.max' => 'Phone cannot exceed 20 characters.',

            

        ];
    }
}
