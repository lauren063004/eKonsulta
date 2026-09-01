<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use App\Models\HealthCenter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Get Health Centers
        |--------------------------------------------------------------------------
        */

        $pembo = HealthCenter::where('name', 'Pembo Health Center')->first();
        $pitogo = HealthCenter::where('name', 'Pitogo Health Center')->first();
        $rizal = HealthCenter::where('name', 'Rizal Health Center')->first();


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@ekonsulta.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);


        /*
        |--------------------------------------------------------------------------
        | PATIENT
        |--------------------------------------------------------------------------
        */

        $patientUser = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'patient@ekonsulta.test',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $patientUser->id,
            'patient_number' => 'PAT-2026-00001',
            'date_of_birth' => '2000-05-15',
            'sex' => 'Male',
            'contact_number' => '09171234567',
            'address' => 'Pembo, Taguig City',
            'emergency_contact_name' => 'Maria Dela Cruz',
            'emergency_contact_number' => '09179876543',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DOCTOR
        |--------------------------------------------------------------------------
        */

        $doctorUser = User::create([
            'name' => 'Dr. Maria Santos',
            'email' => 'doctor@ekonsulta.test',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'health_center_id' => $pitogo->id,
            'license_number' => 'MD-2026-00001',
            'specialization' => 'General Medicine',
            'contact_number' => '09175555555',
        ]);


        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
        */

        $staffUser = User::create([
            'name' => 'Ana Reyes',
            'email' => 'staff@ekonsulta.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        Staff::create([
            'user_id' => $staffUser->id,
            'health_center_id' => $rizal->id,
            'employee_number' => 'EMP-2026-00001',
            'position' => 'Health Center Staff',
            'contact_number' => '09176666666',
        ]);
    }
}