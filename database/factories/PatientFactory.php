<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => fake()->name(),
            'phone' => fake()->unique()->numerify('##########'),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
            'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'genotype' => fake()->randomElement(['AA', 'AS', 'SS', 'AC', 'SC']),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
            'emergency_contact' => fake()->phoneNumber(),
            'allergies' => fake()->optional()->sentence(),
            'conditions' => fake()->optional()->sentence(),
            'ward_id' => \App\Models\Ward::factory(),
            'photo' => null,
        ];
    }
}
