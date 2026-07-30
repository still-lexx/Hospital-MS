<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? \App\Models\Patient::factory(),
            'appointment_id' => \App\Models\Appointment::inRandomOrder()->first()?->id ?? \App\Models\Appointment::factory(),
            'invoice_number' => 'BILL-' . fake()->unique()->numerify('##########'),
            'amount' => fake()->randomFloat(2, 50, 5000),
            'paid_amount' => 0,
            'status' => 'unpaid',
            'payment_method' => fake()->randomElement(['Cash', 'Card', 'Insurance']),
            'billing_date' => fake()->date(),
            'description' => fake()->sentence(),
        ];
    }
}
