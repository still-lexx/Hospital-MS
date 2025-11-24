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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
             // Foreign keys
             $table->foreignId('patient_id')->constrained()->onDelete('cascade');
             $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
 
             // Prescription details
             $table->text('medications'); // List of medications prescribed
             $table->text('instructions')->nullable(); // Special instructions for the patient
             $table->date('prescribed_at'); // Date of prescription
             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
