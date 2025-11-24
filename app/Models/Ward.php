<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'status',
    ];

    // ward can have many admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
