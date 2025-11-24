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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
             // Foreign key to users table
             $table->foreignId('user_id')->constrained()->onDelete('cascade');

             // Doctor profile fields
             $table->string('phone')->nullable();
             $table->string('address')->nullable();
             $table->string('specialization')->nullable();
             $table->string('qualification')->nullable();
             $table->integer('experience')->nullable(); // years
             $table->string('license_number')->nullable();
             $table->text('bio')->nullable();
             $table->string('photo')->nullable(); // path to uploaded image
             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
