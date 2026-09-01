<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\HealthCenter;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'health_center_id',
        'license_number',
        'specialization',
        'contact_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthCenter()
    {
        return $this->belongsTo(HealthCenter::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}