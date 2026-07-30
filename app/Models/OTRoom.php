<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTRoom extends Model
{
    use HasFactory;

    protected $table = 'ot_rooms';

    protected $fillable = [
        'room_number',
        'room_name',
        'status',
        'equipment',
        'capacity',
    ];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'ot_room_id');
    }
}
