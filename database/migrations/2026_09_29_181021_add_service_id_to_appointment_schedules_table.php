<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // service_id already exists in appointment_schedules.
        // This migration is intentionally left empty.
    }

    public function down(): void
    {
        // Do not remove service_id here because it is already
        // managed by the migration that originally created it.
    }
};