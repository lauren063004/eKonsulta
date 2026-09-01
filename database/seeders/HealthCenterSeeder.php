<?php

namespace Database\Seeders;

use App\Models\HealthCenter;
use Illuminate\Database\Seeder;

class HealthCenterSeeder extends Seeder
{
    public function run(): void
    {
        HealthCenter::create([
            'name' => 'Pembo Health Center',
            'address' => 'Pembo, Taguig City',
            'contact_number' => '09170000001',
            'email' => 'pembo@ekonsulta.test',
            'operating_hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            'status' => 'active',
        ]);

        HealthCenter::create([
            'name' => 'Pitogo Health Center',
            'address' => 'Pitogo, Taguig City',
            'contact_number' => '09170000002',
            'email' => 'pitogo@ekonsulta.test',
            'operating_hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            'status' => 'active',
        ]);

        HealthCenter::create([
            'name' => 'Rizal Health Center',
            'address' => 'Rizal, Taguig City',
            'contact_number' => '09170000003',
            'email' => 'rizal@ekonsulta.test',
            'operating_hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            'status' => 'active',
        ]);
    }
}