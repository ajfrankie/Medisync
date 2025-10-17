<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNurseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ✅ Allow all users for now — restrict later if needed
    }

    public function rules(): array
    {
        return [
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],

            // Nurse fields
            'shift_time' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'experience' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            // User field messages
            'name.required' => 'Nurse name is required.',
            'name.string' => 'Nurse name must be a valid string.',
            'name.max' => 'Nurse name cannot exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email is already in use.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 6 characters long.',

            'phone.string' => 'Phone number must be a valid string.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',

            // Nurse field messages
            'shift_time.required' => 'Please select a shift time.',
            'shift_time.string' => 'Shift time must be a valid text.',
            'shift_time.max' => 'Shift time text is too long.',

            'department.required' => 'Please select a department.',
            'department.string' => 'Department must be a valid text.',
            'department.max' => 'Department name cannot exceed 255 characters.',

            'experience.integer' => 'Experience must be a valid number.',
            'experience.min' => 'Experience cannot be negative.',
        ];
    }
}
