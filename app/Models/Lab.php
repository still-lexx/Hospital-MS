<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'description',
        'status',
    ];

    //  lab can have many test requests
    public function testRequests()
    {
        return $this->hasMany(TestRequest::class);
    }
}
