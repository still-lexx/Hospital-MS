<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'blood_group',
        'genotype',
        'marital_status',
        'emergency_contact',
        'allergies',
        'conditions',
        'ward_id',
        'admitted',
        'photo'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function labTests()
    {
        return $this->hasManyThrough(LabTest::class, TestRequest::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function testRequests()
    {
        return $this->hasMany(TestRequest::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function wards()
    {
        return $this->belongsToMany(Ward::class, 'admissions');
    }
}
