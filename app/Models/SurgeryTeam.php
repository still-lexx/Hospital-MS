<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgeryTeam extends Model
{
    use HasFactory;

    protected $table = 'surgery_team';

    protected $fillable = [
        'surgery_id',
        'user_id',
        'role',
    ];

    public function surgery()
    {
        return $this->belongsTo(Surgery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
