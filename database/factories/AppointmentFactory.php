<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
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
            'doctor_id' => Doctor::factory(),
            'appointment_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'appointment_time' => fake()->time('H:i'),
            'appointment_type' => fake()->randomElement(['consultation', 'follow-up', 'emergency', 'checkup']),
            'status' => fake()->randomElement(['scheduled', 'confirmed', 'completed', 'cancelled', 'pending']),
            'reason' => fake()->sentence(),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
