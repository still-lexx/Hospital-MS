<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'inventory_item_id' => InventoryItem::factory(),
            'quantity' => fake()->numberBetween(0, 100),
            'unit_price' => fake()->randomFloat(2, 5, 200),
            'batch_number' => 'BATCH-' . fake()->bothify('###??'),
            'expiry_date' => fake()->dateTimeBetween('now', '+2 years'),
            'location' => fake()->randomElement(['Main Store', 'Pharmacy', 'Emergency Ward', 'Lab']),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(1, 5),
        ]);
    }
}
