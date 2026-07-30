<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opd_vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_visit_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2)->nullable(); // kg
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->integer('bp_systolic')->nullable();
            $table->integer('bp_diastolic')->nullable();
            $table->decimal('temperature', 4, 1)->nullable(); // Celsius
            $table->integer('pulse')->nullable(); // bpm
            $table->integer('respiratory_rate')->nullable(); // breaths/min
            $table->integer('spo2')->nullable(); // percentage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opd_vitals');
    }
};
