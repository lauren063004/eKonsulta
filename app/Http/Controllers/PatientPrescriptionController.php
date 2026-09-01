<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\View\View;

class PatientPrescriptionController extends Controller
{
    /**
     * Display prescriptions belonging to the logged-in patient.
     */
    public function index(): View
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        $prescriptions = Prescription::with([
            'doctor.user',
            'consultation',
            'items.medicine',
        ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('prescription_date')
            ->get();

        return view('patient.prescriptions.index', compact(
            'prescriptions'
        ));
    }
}