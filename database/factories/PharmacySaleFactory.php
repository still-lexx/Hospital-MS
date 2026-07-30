<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacySaleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'prescription_id' => \App\Models\Prescription::inRandomOrder()->first()?->id ?? \App\Models\Prescription::factory(),
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? \App\Models\Patient::factory(),
            'sale_date' => fake()->date(),
            'total_amount' => fake()->randomFloat(2, 20, 2000),
            'payment_method' => fake()->randomElement(['cash', 'card', 'insurance', 'transfer']),
            'status' => 'completed',
        ];
    }
}
