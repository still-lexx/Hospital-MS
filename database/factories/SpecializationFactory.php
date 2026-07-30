<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Cardiologist', 'Neurologist', 'Orthopedic Surgeon', 'Pediatrician', 
                'Oncologist', 'Gynecologist', 'Dermatologist', 'Psychiatrist',
                'Radiologist', 'Urologist', 'Ophthalmologist', 'Gastroenterologist',
                'Endocrinologist', 'Dentist', 'ENT Specialist', 'General Surgeon',
                'Anesthesiologist', 'Pathologist', 'Nephrologist', 'Pulmonologist'
            ]),
            'description' => fake()->sentence(),
            'is_active' => 1,
        ];
    }
}
