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
            // Add ward_id as foreign key
            $table->foreignId('ward_id')->nullable()->after('conditions')->constrained('wards')->onDelete('set null');
            
            // Drop old ward column if it exists
            if (Schema::hasColumn('patients', 'ward')) {
                $table->dropColumn('ward');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['ward_id']);
            $table->dropColumn('ward_id');
            
            // Restore old ward column
            $table->text('ward')->nullable();
        });
    }
};
