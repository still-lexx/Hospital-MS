<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'ward_id' => Ward::factory(),
            'doctor_id' => User::factory()->state(['role' => 'doctor']),
            'admission_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => 'Admitted',
        ];
    }
}
