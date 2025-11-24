<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Constants for appointment status
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_NO_SHOW = 'no-show';

    // Constants for appointment type
    const TYPE_CONSULTATION = 'consultation';
    const TYPE_FOLLOW_UP = 'follow-up';
    const TYPE_EMERGENCY = 'emergency';
    const TYPE_CHECKUP = 'checkup';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_type',
        'appointment_date',
        'appointment_time',
        'reason',
        'duration',
        'consultation_fee',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'consultation_fee' => 'decimal:2',
    ];

     // Relationship: Appointment belongs to a Patient
     public function patient()
     {
         return $this->belongsTo(Patient::class);
     }
 
     // Relationship: Appointment belongs to a Doctor
     public function doctor()
     {
         return $this->belongsTo(Doctor::class);
     }

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    // Scope: Upcoming appointments
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                     ->whereIn('status', [self::STATUS_SCHEDULED, self::STATUS_CONFIRMED])
                     ->orderBy('appointment_date')
                     ->orderBy('appointment_time');
    }

    // Scope: Today's appointments
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    // Scope: By status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
