<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'type', // medical, equipment, pharmacy, etc.
    ];

    /**
     * Get all inventory items in this category
     */
    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
