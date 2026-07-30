<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = ['ward_id', 'bed_number', 'daily_charge', 'status'];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function admissions()
    {
        return $this->hasMany(IpdAdmission::class);
    }

    public function currentAdmission()
    {
        return $this->hasOne(IpdAdmission::class)->where('status', 'admitted');
    }
}
