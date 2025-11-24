<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appointment_type' => 'required|in:consultation,follow-up,emergency,checkup',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:120',
            'status' => 'nullable|in:scheduled,confirmed,completed,cancelled,no-show',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_time.required' => 'Appointment time is required.',
        ];
    }
}
