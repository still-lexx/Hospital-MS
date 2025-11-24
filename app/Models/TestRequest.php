<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'lab_id',
        'test_name',
        'description',
        'request_date',
        'status',
    ];

    // test request belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // test request is made by a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // test request is assigned to a lab
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
