<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgeryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'surgery_id',
        'pre_operative_diagnosis',
        'post_operative_diagnosis',
        'procedure_details',
        'complications',
        'blood_loss',
        'report_date',
        'reported_by',
    ];

    protected $casts = [
        'report_date' => 'datetime',
    ];

    public function surgery()
    {
        return $this->belongsTo(Surgery::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
