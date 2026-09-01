<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\View\View;

class StaffPatientController extends Controller
{
    /**
     * Display all registered patients.
     */
    public function index(): View
    {
        $patients = Patient::with('user')
            ->orderBy('id')
            ->get();

        return view('staff.patients.index', compact('patients'));
    }

    /**
     * Display a patient's details.
     */
    public function show(Patient $patient): View
    {
        $patient->load([
            'user',
            'appointments.doctor.user',
            'appointments.healthCenter',
            'consultations.doctor.user',
            'prescriptions.items.medicine',
        ]);

        return view('staff.patients.show', compact('patient'));
    }
}