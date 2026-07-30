<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\User::where('role', 'doctor')->inRandomOrder()->first()?->id ?? \App\Models\User::factory()->state(['role' => 'doctor']),
            'prescription_date' => fake()->date(),
            'notes' => fake()->sentence(),
        ];
    }
}
