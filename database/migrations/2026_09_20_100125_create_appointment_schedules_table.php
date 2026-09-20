<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('health_center_id')
                ->constrained('health_centers')
                ->restrictOnDelete();

            $table->date('schedule_date');

            $table->time('appointment_time');

            $table->unsignedInteger('capacity')->default(1);

            $table->timestamps();

         $table->unique(
    [
        'health_center_id',
        'schedule_date',
        'appointment_time',
    ],
    'schedule_slot_unique'
);

            $table->index([
                'health_center_id',
                'schedule_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_schedules');
    }
};