<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'prescription_id' => Prescription::factory(),
            'medicine_name' => fake()->word(),
            'dosage' => fake()->word(),
            'frequency' => fake()->word(),
            'duration' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 20),
            'instructions' => fake()->sentence(),
        ];
    }
}
