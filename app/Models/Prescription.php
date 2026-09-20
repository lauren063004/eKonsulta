<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\PrescriptionItem;
use App\Models\User;

class Prescription extends Model
{
    use HasFactory;

   protected $fillable = [
    'consultation_id',
    'patient_id',
    'doctor_id',
    'prescription_number',
    'prescription_date',
    'instructions',
    'status',
    'released_at',
    'released_by',
];

  protected function casts(): array
{
    return [
        'prescription_date' => 'date',
        'released_at' => 'datetime',
    ];
}

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function releasedBy()
{
    return $this->belongsTo(User::class, 'released_by');
}

public function items()
{
    return $this->hasMany(PrescriptionItem::class);
}
}