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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('appointment_type', ['consultation', 'follow-up', 'emergency', 'checkup'])->default('consultation')->after('doctor_id');
            $table->date('appointment_date')->after('appointment_type');
            $table->time('appointment_time')->after('appointment_date');
            $table->text('reason')->nullable()->after('appointment_time');
            $table->integer('duration')->default(30)->after('reason'); // minutes
            $table->decimal('consultation_fee', 10, 2)->nullable()->after('duration');
            
            // Drop old scheduled_at column
            $table->dropColumn('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->after('doctor_id');
            $table->dropColumn(['appointment_type', 'appointment_date', 'appointment_time', 'reason', 'duration', 'consultation_fee']);
        });
    }
};
