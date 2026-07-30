<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = fake()->randomFloat(2, 100, 5000);
        $tax = $subTotal * 0.05;
        $discount = 0;
        $total = $subTotal + $tax - $discount;

        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()?->id ?? \App\Models\Doctor::factory(),
            'invoice_date' => fake()->date(),
            'due_date' => fake()->optional()->date(),
            'total_amount' => $total,
            'tax_amount' => $tax,
            'discount_amount' => $discount,
            'status' => fake()->randomElement(['draft', 'unpaid', 'paid', 'partial', 'cancelled']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
