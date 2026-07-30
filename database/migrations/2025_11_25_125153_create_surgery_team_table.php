<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surgery_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surgery_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['surgeon', 'assistant', 'anesthetist', 'nurse'])->default('nurse');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surgery_team');
    }
};
