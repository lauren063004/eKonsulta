<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('health_center_id')
                ->nullable()
                ->after('user_id')
                ->constrained('health_centers')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['health_center_id']);
            $table->dropColumn('health_center_id');
        });
    }
};