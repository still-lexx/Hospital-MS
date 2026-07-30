<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use App\Models\Bed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IpdAdmission>
 */
class IpdAdmissionFactory extends Factory
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
            'bed_id' => Bed::factory(),
            'admission_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'discharge_date' => null,
            'reason' => fake()->sentence(),
            'status' => 'admitted',
            'discharge_summary' => null,
            'deposit_amount' => fake()->randomFloat(2, 500, 2000),
        ];
    }
}
