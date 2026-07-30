<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'lab_test_id',
        'request_date',
        'status',
        'priority',
        'notes',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    public function result()
    {
        return $this->hasOne(LabResult::class);
    }
}
