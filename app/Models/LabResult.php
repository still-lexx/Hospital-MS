<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_test_request_id',
        'result_value',
        'result_date',
        'performed_by',
        'remarks',
        'status',
    ];

    protected $casts = [
        'result_date' => 'datetime',
    ];

    public function testRequest()
    {
        return $this->belongsTo(LabTestRequest::class, 'lab_test_request_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
