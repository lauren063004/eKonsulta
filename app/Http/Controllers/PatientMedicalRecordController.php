<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\View\View;


class PatientMedicalRecordController extends Controller
{
    /**
     * Display the patient's medical records.
     */
    public function index(): View
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        $consultations = Consultation::with([
            'doctor.user',
            'appointment.healthCenter',
            'prescriptions.items.medicine',
        ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('consultation_date')
            ->get();

        return view('patient.medical-records.index', compact(
            'consultations'
        ));
    }
}