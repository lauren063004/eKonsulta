<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->foreignId('doctor_id')
                ->nullable()
                ->after('service_id')
                ->constrained('doctors')
                ->nullOnDelete();

            $table->index([
                'doctor_id',
                'schedule_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropIndex([
                'doctor_id',
                'schedule_date',
            ]);
            $table->dropColumn('doctor_id');
        });
    }
};