<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bed>
 */
class BedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ward_id' => Ward::factory(),
            'bed_number' => 'BED-' . fake()->unique()->numberBetween(1000, 9999),
            'daily_charge' => fake()->randomFloat(2, 50, 500),
            'status' => fake()->randomElement(['available', 'occupied', 'maintenance']),
        ];
    }
}
