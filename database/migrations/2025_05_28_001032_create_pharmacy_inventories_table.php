<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pharmacy_inventories', function (Blueprint $table) {
            $table->id();
            // Medication details
            $table->string('medication_name');
            $table->string('medication_code')->unique(); // Unique medication code or identifier
            $table->text('description')->nullable(); // Additional details about the medication
            $table->decimal('price_per_unit', 10, 2); // Price per unit of the medication
            $table->integer('stock_quantity')->default(0); // Available stock
            $table->date('expiry_date')->nullable(); // Expiry date of the medication
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available'); // Current status

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_inventories');
    }
};
