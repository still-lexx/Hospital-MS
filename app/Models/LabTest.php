<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'normal_range',
        'unit',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function testRequests()
    {
        return $this->hasMany(LabTestRequest::class);
    }
}
