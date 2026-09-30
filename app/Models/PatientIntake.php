<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientIntake extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'staff_id',
        'height',
        'weight',
        'comorbidities',
        'maintenance_medications',
        'allergies',
        'has_diabetes',
        'has_hypertension',
        'other_medical_information',
        'completed_at',
    ];

    protected $casts = [
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'has_diabetes' => 'boolean',
        'has_hypertension' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}