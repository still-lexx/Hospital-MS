<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_visit_id',
        'weight',
        'height',
        'bp_systolic',
        'bp_diastolic',
        'temperature',
        'pulse',
        'respiratory_rate',
        'spo2',
    ];

    public function visit()
    {
        return $this->belongsTo(OpdVisit::class, 'opd_visit_id');
    }
}
