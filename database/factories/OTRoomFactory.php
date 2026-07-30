<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OTRoom>
 */
class OTRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => 'OT-' . fake()->unique()->numberBetween(1, 1000),
            'room_name' => 'Operation Theater ' . fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['available', 'occupied', 'maintenance']),
            'equipment' => fake()->sentence(),
            'capacity' => fake()->numberBetween(1, 5),
        ];
    }
}
