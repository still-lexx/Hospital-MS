<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: Specialization has many doctors
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_specialization');
    }

    // Scope: Only active specializations
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
