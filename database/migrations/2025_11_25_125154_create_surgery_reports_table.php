<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surgery_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surgery_id')->constrained()->onDelete('cascade');
            $table->text('pre_operative_diagnosis');
            $table->text('post_operative_diagnosis')->nullable();
            $table->text('procedure_details');
            $table->text('complications')->nullable();
            $table->string('blood_loss')->nullable();
            $table->dateTime('report_date');
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surgery_reports');
    }
};
