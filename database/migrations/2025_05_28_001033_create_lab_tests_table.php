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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');

            // Lab test details
            $table->string('test_name');           // Name of the lab test
            $table->text('description')->nullable(); // Description of the test
            $table->date('test_date');              // Date when the test was conducted
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Status of the test
            $table->text('results')->nullable();   // Test results (can store as JSON or text)
            $table->text('notes')->nullable();     // Additional notes related to the test

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
