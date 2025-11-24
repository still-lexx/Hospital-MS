<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PharmacyInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_name',
        'medication_code',
        'description',
        'price_per_unit',
        'stock_quantity',
        'expiry_date',
        'status',
    ];
}
