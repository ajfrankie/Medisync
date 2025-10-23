<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'        => ['required', 'exists:users,id'],
            'specialization' => ['required', 'string', 'max:255'],
            'department'     => ['required', 'string', 'max:255'],
            'experience'     => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a user.',
            'user_id.exists'   => 'Selected user does not exist.',
            'specialization.required' => 'Specialization is required.',
            'department.required' => 'Department is required.',
        ];
    }
}
