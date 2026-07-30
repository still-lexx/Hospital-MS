<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'ot_room_id',
        'surgery_name',
        'surgery_date',
        'start_time',
        'end_time',
        'status',
        'type',
        'notes',
    ];

    protected $casts = [
        'surgery_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function otRoom()
    {
        return $this->belongsTo(OTRoom::class, 'ot_room_id');
    }

    public function team()
    {
        return $this->hasMany(SurgeryTeam::class);
    }

    public function report()
    {
        return $this->hasOne(SurgeryReport::class);
    }
}
