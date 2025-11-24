<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_number',
        'amount',
        'paid_amount',
        'status',
        'payment_method',
        'billing_date',
        'description',
    ];

    // billing record belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // billing record may be linked to an appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function admissions()
    {
        return $this->hasOne(Admission::class);
    }
}
