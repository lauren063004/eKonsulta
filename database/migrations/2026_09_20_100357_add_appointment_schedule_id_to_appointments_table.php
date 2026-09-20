<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('appointment_schedule_id')
                ->nullable()
                ->after('health_center_id')
                ->constrained('appointment_schedules')
                ->nullOnDelete();

            $table->index('appointment_schedule_id');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign([
                'appointment_schedule_id',
            ]);

            $table->dropIndex([
                'appointment_schedule_id',
            ]);

            $table->dropColumn('appointment_schedule_id');
        });
    }
};