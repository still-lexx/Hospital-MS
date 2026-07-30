<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->randomElement([
                'Paracetamol 500mg', 'Amoxicillin 250mg', 'Surgical Face Mask', 'Sterile Gloves', 
                'Syringe 5ml', 'IV Fluid 500ml', 'Adhesive Bandage', 'Alcohol Swabs',
                'Digital Thermometer', 'Blood Pressure Monitor', 'Stethoscope', 'Surgical Gown',
                'Oxygen Mask', 'Catheter', 'ECG Electrodes', 'Hand Sanitizer'
            ]),
            'sku' => fake()->unique()->bothify('SKU-####-????'),
            'description' => fake()->sentence(),
            'unit' => fake()->randomElement(['box', 'bottle', 'piece', 'pack', 'vial']),
            'reorder_level' => 10,
            'status' => 'active',
        ];
    }
}
