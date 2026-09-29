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
        | service_id was already added before the previous migration failed.
        |--------------------------------------------------------------------------
        |
        | We do NOT add service_id again.
        |
        */

        /*
        |--------------------------------------------------------------------------
        | Add an index for health_center_id
        |--------------------------------------------------------------------------
        |
        | The old schedule_slot_unique index was also being used by the
        | health_center_id foreign key because health_center_id was the
        | first column of that composite index.
        |
        | Therefore, we must create a separate index before removing
        | schedule_slot_unique.
        |
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->index(
                'health_center_id',
                'appointment_schedules_health_center_id_index'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Replace Old Unique Constraint
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
        | Restore Original Unique Constraint
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
        | Remove Separate health_center_id Index
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropIndex(
                'appointment_schedules_health_center_id_index'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Remove service_id
        |--------------------------------------------------------------------------
        */

        Schema::table('appointment_schedules', function (Blueprint $table) {
            $table->dropForeign([
                'service_id',
            ]);

            $table->dropColumn('service_id');
        });
    }
};