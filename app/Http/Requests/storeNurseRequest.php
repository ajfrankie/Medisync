<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNurseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'        => ['required', 'exists:users,id'],
            'shift_time' => ['required', 'string', 'max:255'],
            'department'     => ['required', 'string', 'max:255'],
            'experience'     => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
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
