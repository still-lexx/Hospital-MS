<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_type' => 'required|in:consultation,follow-up,emergency,checkup',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:120',
            'consultation_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'doctor_id.required' => 'Please select a doctor.',
            'appointment_date.after_or_equal' => 'Appointment date must be today or in the future.',
        ];
    }
}
