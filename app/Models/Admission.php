<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'ward_id',
        'doctor_id',
        'billing_id',
        'admitted_at',
        'discharged_at',
        'status',
        'notes',
    ];

    // An admission belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // An admission belongs to a ward
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    // An admission may have an attending doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // An admission may have an associated billing record
    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
