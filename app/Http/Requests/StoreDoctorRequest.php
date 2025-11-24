<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'qualification' => 'required|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'license_number' => 'required|string|unique:doctors,license_number',
            'bio' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'exists:specializations,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a user account for the doctor.',
            'user_id.unique' => 'This user is already registered as a doctor.',
            'specializations.required' => 'Please select at least one specialization.',
            'license_number.unique' => 'This license number is already registered.',
        ];
    }
}
