<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Add service_id to appointment_schedules
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->foreignId('service_id')
                ->after('health_center_id')
                ->constrained('services')
                ->restrictOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Replace the old schedule uniqueness rule
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropUnique('schedule_slot_unique');

            $table->unique(
                [
                    'health_center_id',
                    'service_id',
                    'schedule_date',
                    'appointment_time',
                ],
                'schedule_slot_unique'
            );
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Restore original schedule uniqueness rule
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropUnique('schedule_slot_unique');

            $table->unique(
                [
                    'health_center_id',
                    'schedule_date',
                    'appointment_time',
                ],
                'schedule_slot_unique'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Remove service_id
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
    }
};