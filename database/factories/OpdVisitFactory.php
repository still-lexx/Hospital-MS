<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpdVisit>
 */
class OpdVisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => User::factory()->state(['role' => 'doctor']),
            'visit_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['waiting', 'in-consultation', 'completed', 'cancelled']),
            'token_number' => fake()->unique()->numberBetween(100, 999),
        ];
    }
}
