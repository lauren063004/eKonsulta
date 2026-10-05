<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
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

    /**
     * Display a single prescription.
     */
    public function show(Prescription $prescription): View
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        if ($prescription->patient_id !== $patient->id) {
            abort(403, 'You are not authorized to view this prescription.');
        }

        $prescription->load([
            'patient.user',
            'doctor.user',
            'items.medicine',
            'consultation',
        ]);

        return view('patient.prescriptions.show', compact(
            'prescription'
        ));
    }

    /**
     * Download prescription as PDF.
     */
    public function download(Prescription $prescription)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        if ($prescription->patient_id !== $patient->id) {
            abort(403, 'You are not authorized to download this prescription.');
        }

        $prescription->load([
            'patient.user',
            'doctor.user',
            'items.medicine',
            'consultation',
        ]);

        $pdf = Pdf::loadView(
            'doctor.prescriptions.pdf',
            compact('prescription')
        );

        $filename = $prescription->prescription_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Print-friendly prescription page.
     */
    public function print(Prescription $prescription): View
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        if ($prescription->patient_id !== $patient->id) {
            abort(403, 'You are not authorized to print this prescription.');
        }

        $prescription->load([
            'patient.user',
            'doctor.user',
            'items.medicine',
            'consultation',
        ]);

        return view('doctor.prescriptions.print', compact(
            'prescription'
        ));
    }
}