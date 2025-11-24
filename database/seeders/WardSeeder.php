<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = [
            ['name' => 'General Ward', 'capacity' => 50, 'description' => 'General patient care ward'],
            ['name' => 'ICU', 'capacity' => 20, 'description' => 'Intensive Care Unit'],
            ['name' => 'Emergency', 'capacity' => 30, 'description' => 'Emergency and trauma care'],
            ['name' => 'Pediatric', 'capacity' => 40, 'description' => 'Children and infant care'],
            ['name' => 'Maternity', 'capacity' => 35, 'description' => 'Maternity and obstetrics ward'],
        ];

        foreach ($wards as $ward) {
            \App\Models\Ward::create($ward);
        }
    }
}
