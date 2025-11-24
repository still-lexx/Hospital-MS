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
        Schema::table('patients', function (Blueprint $table) {
            // Optimize column types from text to more appropriate types
            $table->string('name', 255)->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
            // address remains text
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable()->change();
            $table->enum('genotype', ['AA', 'AS', 'SS', 'AC', 'SC'])->nullable()->change();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->change();
            $table->string('emergency_contact', 255)->nullable()->change();
            // allergies remains text
            // conditions remains text
            $table->string('ward', 100)->nullable()->change();
            $table->boolean('admitted')->nullable()->default(false)->change();
            $table->string('photo')->nullable()->change();
            
            // Add index on phone for faster lookups
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Revert back to text columns
            $table->dropIndex(['phone']);
            
            $table->text('name')->nullable()->change();
            $table->text('phone')->nullable()->change();
            $table->text('gender')->nullable()->change();
            $table->text('date_of_birth')->nullable()->change();
            $table->text('blood_group')->nullable()->change();
            $table->text('genotype')->nullable()->change();
            $table->text('marital_status')->nullable()->change();
            $table->text('emergency_contact')->nullable()->change();
            $table->text('ward')->nullable()->change();
            $table->text('admitted')->nullable()->change();
        });
    }
};
