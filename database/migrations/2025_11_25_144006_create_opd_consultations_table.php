<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opd_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_visit_id')->constrained()->onDelete('cascade');
            $table->text('diagnosis')->nullable();
            $table->text('symptoms')->nullable();
            $table->text('examination_notes')->nullable();
            $table->text('advice')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opd_consultations');
    }
};
