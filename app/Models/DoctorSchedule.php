<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    // Relationship: Schedule belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Scope: Only available schedules
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Get time slots for this schedule
    public function getTimeSlots()
    {
        $slots = [];
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);

        while ($start->lt($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes($this->slot_duration);
        }

        return $slots;
    }
}
