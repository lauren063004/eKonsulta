<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffPrescriptionController extends Controller
{
    public function index(): View
    {
        $prescriptions = Prescription::with([
            'patient.user',
            'doctor.user',
            'consultation',
            'items.medicine',
            'releasedBy',
        ])
            ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
            ->orderByDesc('prescription_date')
            ->get();

        return view('staff.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription): View
    {
        $prescription->load([
            'patient.user',
            'doctor.user',
            'consultation',
            'consultation.appointment.healthCenter',
            'items.medicine',
            'releasedBy',
        ]);

        return view('staff.prescriptions.show', compact('prescription'));
    }

    public function release(Prescription $prescription): RedirectResponse
    {
        if ($prescription->status !== 'active') {
            return redirect()
                ->route('staff.prescriptions.show', $prescription)
                ->with('error', 'This prescription has already been released or is no longer active.');
        }

        $prescription->update([
            'status' => 'released',
            'released_at' => now(),
            'released_by' => auth()->id(),
        ]);

        return redirect()
            ->route('staff.prescriptions.show', $prescription)
            ->with('success', 'Medicine released successfully.');
    }
}