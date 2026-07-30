<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsuranceClaimFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? \App\Models\Patient::factory(),
            'invoice_id' => \App\Models\Invoice::inRandomOrder()->first()?->id ?? \App\Models\Invoice::factory(),
            'provider_name' => fake()->company() . ' Insurance',
            'policy_number' => fake()->bothify('POL-##########'),
            'claim_number' => fake()->bothify('CLM-##########'),
            'status' => 'pending',
            'claim_amount' => fake()->randomFloat(2, 100, 5000),
        ];
    }
}
