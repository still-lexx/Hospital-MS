<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'description',
        'test_date',
        'status',
        'results',
        'notes',
    ];

    // lab test belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // lab test is ordered by a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
