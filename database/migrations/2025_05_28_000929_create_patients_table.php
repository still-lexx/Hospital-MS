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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            // Foreign key to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Patient details
            $table->text('name')->nullable();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('gender')->nullable();
            $table->text('date_of_birth')->nullable();
            $table->text('blood_group')->nullable();
            $table->text('genotype')->nullable();
            $table->text('marital_status')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->text('allergies')->nullable();
            $table->text('conditions')->nullable();
            $table->text('ward')->nullable();
            $table->text('Admitted')->nullable();
            $table->text('photo')->nullable(); // File path to photo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
