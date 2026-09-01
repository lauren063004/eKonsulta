<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\View\View;

class StaffConsultationController extends Controller
{
    /**
     * Display all consultations for staff.
     */
    public function index(): View
    {
        $consultations = Consultation::with([
            'patient.user',
            'doctor.user',
            'appointment.healthCenter',
            'prescriptions.items.medicine',
        ])
            ->orderByDesc('consultation_date')
            ->get();

        return view('staff.consultations.index', compact(
            'consultations'
        ));
    }

    /**
     * Display consultation details.
     */
    public function show(Consultation $consultation): View
    {
        $consultation->load([
            'patient.user',
            'doctor.user',
            'appointment.healthCenter',
            'prescriptions.items.medicine',
        ]);

        return view('staff.consultations.show', compact(
            'consultation'
        ));
    }
}
