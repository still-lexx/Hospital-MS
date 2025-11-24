<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'inventory_item_id',
        'quantity',
        'unit_price',
        'batch_number',
        'expiry_date',
        'location',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the inventory item that owns this stock
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
