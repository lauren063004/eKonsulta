<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('health_center_id')
                ->constrained('health_centers')
                ->restrictOnDelete();

            $table->string('name');
            $table->string('generic_name');
            $table->string('dosage_form', 100);
            $table->string('strength', 100);

            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('unit', 50);

            $table->date('expiration_date')->nullable();
            $table->string('status', 30)->default('active');

            $table->timestamps();

            $table->index(['health_center_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};