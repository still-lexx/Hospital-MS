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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
             // Ward details
             $table->string('name');               // Name of the ward (e.g., ICU, General, Maternity)
             $table->text('description')->nullable(); // A description of the ward or its purpose
             $table->integer('capacity');          // Maximum capacity (number of beds)
             $table->enum('status', ['active', 'inactive'])->default('active'); // Ward status (active/inactive)
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
