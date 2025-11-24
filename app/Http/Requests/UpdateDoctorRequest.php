<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor');
        
        return [
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'qualification' => 'required|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctorId,
            'bio' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'exists:specializations,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'specializations.required' => 'Please select at least one specialization.',
            'license_number.unique' => 'This license number is already registered.',
        ];
    }
}
