<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_centers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('address');
            $table->string('contact_number', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('operating_hours')->nullable();
            $table->string('status', 20)->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_centers');
    }
};