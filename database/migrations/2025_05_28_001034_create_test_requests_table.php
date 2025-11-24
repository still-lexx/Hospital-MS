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
        Schema::create('test_requests', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            // $table->foreignId('lab_id')->constrained()->onDelete('cascade'); // Lab where the test is to be performed

            // Test request details
            $table->string('test_name');            // Name of the test requested
            $table->text('description')->nullable(); // Description of the test requested
            $table->date('request_date');           // Date when the test was requested
            $table->enum('status', ['pending', 'approved', 'completed', 'canceled'])->default('pending'); // Status of the request

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_requests');
    }
};
