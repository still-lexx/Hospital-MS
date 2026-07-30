<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_visit_id',
        'diagnosis',
        'symptoms',
        'examination_notes',
        'advice',
        'next_visit_date',
    ];

    protected $casts = [
        'next_visit_date' => 'date',
    ];

    public function visit()
    {
        return $this->belongsTo(OpdVisit::class, 'opd_visit_id');
    }
}
