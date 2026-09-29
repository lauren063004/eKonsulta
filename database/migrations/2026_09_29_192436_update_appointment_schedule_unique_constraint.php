<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Add a separate index for health_center_id
            |--------------------------------------------------------------------------
            |
            | The old unique index:
            |
            | health_center_id + schedule_date + appointment_time
            |
            | is currently being used by MySQL to support the
            | health_center_id foreign key.
            |
            | We need a separate index before removing the old
            | unique constraint.
            |
            */

            $table->index(
                'health_center_id',
                'appointment_schedules_health_center_id_index'
            );
        });

        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Remove Old Unique Constraint
            |--------------------------------------------------------------------------
            */

            $table->dropUnique('schedule_slot_unique');
        });

        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Create New Unique Constraint
            |--------------------------------------------------------------------------
            |
            | A schedule is now unique based on:
            |
            | Health Center
            | Service
            | Date
            | Time
            |
            | This allows different services to have the
            | same appointment time.
            |
            */

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
        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Remove New Unique Constraint
            |--------------------------------------------------------------------------
            */

            $table->dropUnique('schedule_slot_unique');
        });

        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Restore Original Unique Constraint
            |--------------------------------------------------------------------------
            */

            $table->unique(
                [
                    'health_center_id',
                    'schedule_date',
                    'appointment_time',
                ],
                'schedule_slot_unique'
            );
        });

        Schema::table('appointment_schedules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Remove Extra Index
            |--------------------------------------------------------------------------
            */

            $table->dropIndex(
                'appointment_schedules_health_center_id_index'
            );
        });
    }
};