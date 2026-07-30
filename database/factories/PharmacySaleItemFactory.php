<?php

namespace Database\Factories;

use App\Models\PharmacySale;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacySaleItemFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitPrice = fake()->randomFloat(2, 5, 500);
        return [
            'pharmacy_sale_id' => PharmacySale::factory(),
            'inventory_item_id' => InventoryItem::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $quantity * $unitPrice,
        ];
    }
}
