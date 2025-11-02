<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vital_id' => 'required|exists:vitals,id',
            'medicine_name.*' => 'nullable|string|max:255',
            'dosage.*' => 'nullable|string|max:255',
            'frequency.*' => 'nullable|string|max:100',
            'duration.*' => 'nullable|string|max:100',
            'prescription_img_path' => 'nullable|image|max:2048',
            'instructions.*' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'vital_id.required' => 'A vital record must be selected.',
            'vital_id.exists' => 'The selected vital record does not exist.',
            'prescription_img_path.image' => 'The uploaded file must be an image.',
            'prescription_img_path.max' => 'The image size cannot exceed 2MB.',
        ];
    }
}
