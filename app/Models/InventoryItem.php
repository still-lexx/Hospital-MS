<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'unit',
        'reorder_level',
        'status',
    ];

    /**
     * Get the category that owns the inventory item
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all stock records for this item
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Get all stock movements for this item
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Get the total quantity in stock
     */
    public function getTotalQuantityAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    /**
     * Check if item is low on stock
     */
    public function getIsLowStockAttribute()
    {
        return $this->total_quantity <= $this->reorder_level;
    }
}
