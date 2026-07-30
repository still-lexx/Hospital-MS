<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
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
            'record_date' => fake()->date(),
            'diagnosis' => fake()->sentence(),
            'treatment' => fake()->sentence(),
            'prescription' => fake()->sentence(),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
