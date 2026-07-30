<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 
                'Oncology', 'Gynecology', 'Dermatology', 'Psychiatry',
                'Emergency', 'Radiology', 'Pharmacy', 'Pathology',
                'Urology', 'Ophthalmology', 'Gastroenterology', 'Endocrinology',
                'Dental', 'ENT', 'Physical Therapy', 'Surgery'
            ]),
            'description' => fake()->sentence(),
            'status' => 1,
        ];
    }
}
