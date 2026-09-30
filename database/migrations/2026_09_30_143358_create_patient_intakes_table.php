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
        Schema::create('patient_intakes', function (Blueprint $table) {

            $table->id();

            /*
             * Appointment this intake belongs to.
             */
            $table->foreignId('appointment_id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            /*
             * Patient receiving the intake.
             */
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            /*
             * Staff member who performed the intake.
             */
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            /*
             * Basic measurements.
             */
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            /*
             * Medical history.
             */
            $table->text('comorbidities')->nullable();

            $table->text('maintenance_medications')->nullable();

            $table->text('allergies')->nullable();

            /*
             * Common conditions.
             */
            $table->boolean('has_diabetes')
                ->default(false);

            $table->boolean('has_hypertension')
                ->default(false);

            /*
             * Optional additional information.
             */
            $table->text('other_medical_information')
                ->nullable();

            /*
             * When staff completed the intake.
             */
            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();

            /*
             * One intake per appointment.
             */
            $table->unique('appointment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_intakes');
    }
};