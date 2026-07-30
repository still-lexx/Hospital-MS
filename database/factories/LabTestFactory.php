<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LabTest>
 */
class LabTestFactory extends Factory
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
                'Complete Blood Count (CBC)', 'Basic Metabolic Panel (BMP)', 'Lipid Panel', 
                'Liver Function Test (LFT)', 'Hemoglobin A1c', 'Urinalysis', 
                'Prothrombin Time (PT)', 'Thyroid Stimulating Hormone (TSH)', 
                'Blood Glucose', 'Electrolyte Panel', 'C-Reactive Protein (CRP)',
                'PSA Test', 'Vitamin D Test', 'Iron Studies', 'HIV Screen'
            ]),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 20, 500),
            'category' => fake()->randomElement(['Hematology', 'Biochemistry', 'Microbiology', 'Serology', 'Urinalysis']),
            'normal_range' => 'Varies',
            'unit' => 'Varies',
            'status' => 1,
        ];
    }
}
