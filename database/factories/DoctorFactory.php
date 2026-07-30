<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'doctor']),
            'specialization' => fake()->randomElement([
                'Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 
                'Oncology', 'Gynecology', 'Dermatology', 'Psychiatry'
            ]),
            'qualification' => fake()->randomElement(['MBBS', 'MD', 'DO', 'PhD']),
            'experience' => fake()->numberBetween(1, 30),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'bio' => fake()->paragraph(),
            'consultation_fee' => fake()->randomFloat(2, 20, 200),
            'is_available' => true,
        ];
    }
}
