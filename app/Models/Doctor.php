<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'specialization',
        'qualification',
        'experience',
        'license_number',
        'bio',
        'photo',
        'consultation_fee',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'consultation_fee' => 'decimal:2',
    ];

    // Each doctor belongs to a user account
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // doctor can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function labTests()
    {
        return $this->hasManyThrough(LabTest::class, TestRequest::class);
    }

    public function testRequests()
    {
        return $this->hasMany(TestRequest::class);
    }

    // Relationship: Doctor has many specializations (many-to-many)
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specialization');
    }

    // Relationship: Doctor has many schedules
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    // Accessor: Get doctor's full name from user
    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'N/A';
    }

    // Scope: Only available doctors
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
