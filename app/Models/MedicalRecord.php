<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'record_date',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
    ];

    // medical record belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // medical record optionally belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // medical record may be linked to an appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
