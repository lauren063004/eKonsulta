<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Patient intake fields are already created by:
        |
        | 2026_09_30_143358_create_patient_intakes_table.php
        |--------------------------------------------------------------------------
        |
        | This migration is intentionally left empty to preserve the migration
        | history without attempting to add the same columns a second time.
        |
        */
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Nothing to reverse.
        |
        | The patient_intakes table and its fields are owned by the original
        | create_patient_intakes_table migration.
        |--------------------------------------------------------------------------
        */
    }
};