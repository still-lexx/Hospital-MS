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
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
             // Lab details
             $table->string('name');            // Name of the lab
             $table->text('address');           // Address of the lab
             $table->string('phone_number');    // Contact number of the lab
             $table->string('email')->nullable(); // Email address for the lab (optional)
             $table->text('description')->nullable(); // Description of the lab or any special info
             $table->enum('status', ['active', 'inactive'])->default('active'); // Lab status (active/inactive)
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
