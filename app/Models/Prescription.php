<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medications',
        'instructions',
        'prescribed_at',
    ];

    // prescription belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // prescription belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
