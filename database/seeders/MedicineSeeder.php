<?php

namespace Database\Seeders;

use App\Models\HealthCenter;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $pembo = HealthCenter::where('name', 'Pembo Health Center')->first();
        $pitogo = HealthCenter::where('name', 'Pitogo Health Center')->first();
        $rizal = HealthCenter::where('name', 'Rizal Health Center')->first();

        /*
        |--------------------------------------------------------------------------
        | Pembo Medicines
        |--------------------------------------------------------------------------
        */

        Medicine::create([
            'health_center_id' => $pembo->id,
            'name' => 'Paracetamol',
            'generic_name' => 'Paracetamol',
            'dosage_form' => 'Tablet',
            'strength' => '500 mg',
            'stock_quantity' => 500,
            'unit' => 'tablet',
            'expiration_date' => '2027-12-31',
            'status' => 'active',
        ]);

        Medicine::create([
            'health_center_id' => $pembo->id,
            'name' => 'Amoxicillin',
            'generic_name' => 'Amoxicillin',
            'dosage_form' => 'Capsule',
            'strength' => '500 mg',
            'stock_quantity' => 200,
            'unit' => 'capsule',
            'expiration_date' => '2027-10-31',
            'status' => 'active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pitogo Medicines
        |--------------------------------------------------------------------------
        */

        Medicine::create([
            'health_center_id' => $pitogo->id,
            'name' => 'Paracetamol',
            'generic_name' => 'Paracetamol',
            'dosage_form' => 'Tablet',
            'strength' => '500 mg',
            'stock_quantity' => 350,
            'unit' => 'tablet',
            'expiration_date' => '2027-12-31',
            'status' => 'active',
        ]);

        Medicine::create([
            'health_center_id' => $pitogo->id,
            'name' => 'Ibuprofen',
            'generic_name' => 'Ibuprofen',
            'dosage_form' => 'Tablet',
            'strength' => '200 mg',
            'stock_quantity' => 150,
            'unit' => 'tablet',
            'expiration_date' => '2027-08-31',
            'status' => 'active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Rizal Medicines
        |--------------------------------------------------------------------------
        */

        Medicine::create([
            'health_center_id' => $rizal->id,
            'name' => 'Paracetamol',
            'generic_name' => 'Paracetamol',
            'dosage_form' => 'Tablet',
            'strength' => '500 mg',
            'stock_quantity' => 400,
            'unit' => 'tablet',
            'expiration_date' => '2027-12-31',
            'status' => 'active',
        ]);
    }
}