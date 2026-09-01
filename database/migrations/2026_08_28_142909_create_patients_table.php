<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('patient_number', 50)->unique();

            $table->date('date_of_birth');
            $table->string('sex', 20);
            $table->string('contact_number', 30);
            $table->text('address');

            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number', 30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};