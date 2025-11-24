<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'General Medicine', 'description' => 'General medical practice and primary care'],
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system'],
            ['name' => 'Pediatrics', 'description' => 'Medical care of infants, children, and adolescents'],
            ['name' => 'Orthopedics', 'description' => 'Musculoskeletal system'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nails'],
            ['name' => 'Neurology', 'description' => 'Nervous system'],
            ['name' => 'Gynecology', 'description' => 'Female reproductive system'],
            ['name' => 'Ophthalmology', 'description' => 'Eyes and vision'],
            ['name' => 'ENT', 'description' => 'Ear, Nose, and Throat'],
            ['name' => 'Psychiatry', 'description' => 'Mental health'],
        ];

        foreach ($specializations as $spec) {
            \App\Models\Specialization::create($spec);
        }
    }
}
