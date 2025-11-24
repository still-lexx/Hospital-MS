<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow authenticated users to update patients
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $patientId = $this->route('patient'); // Get patient ID from route parameter
        
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients,phone,' . $patientId,
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'genotype' => 'nullable|in:AA,AS,SS,AC,SC',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'emergency_contact' => 'required|string|max:255',
            'allergies' => 'nullable|string',
            'conditions' => 'nullable|string',
            'ward' => 'nullable|string|max:100',
            'admitted' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Patient name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already registered.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be male, female, or other.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'blood_group.in' => 'Invalid blood group selected.',
            'genotype.in' => 'Invalid genotype selected.',
            'marital_status.in' => 'Invalid marital status selected.',
            'emergency_contact.required' => 'Emergency contact is required.',
            'photo.image' => 'The file must be an image.',
            'photo.max' => 'The image must not be larger than 2MB.',
        ];
    }
}
