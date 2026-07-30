<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\OTRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surgery>
 */
class SurgeryFactory extends Factory
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
            'doctor_id' => \App\Models\User::factory()->state(['role' => 'doctor']),
            'ot_room_id' => OTRoom::factory(),
            'surgery_name' => fake()->randomElement(['Appendectomy', 'Cholecystectomy', 'Hernia Repair', 'Cataract Surgery', 'Hip Replacement', 'Knee Replacement']),
            'surgery_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'start_time' => fake()->time('H:i'),
            'end_time' => null,
            'status' => fake()->randomElement(['scheduled', 'in-progress', 'completed', 'cancelled']),
            'type' => fake()->randomElement(['emergency', 'elective']),
            'notes' => fake()->sentence(),
        ];
    }
}
