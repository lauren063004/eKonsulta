<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffPrescriptionController extends Controller
{
    /**
     * Display prescriptions for the staff member's
     * assigned health center.
     */
    public function index(): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $prescriptions = Prescription::with([
            'patient.user',
            'doctor.user',
            'consultation',
            'items.medicine',
            'releasedBy',
        ])
            ->whereHas('consultation.appointment', function ($query) use ($staff) {
                $query->where(
                    'health_center_id',
                    $staff->health_center_id
                );
            })
            ->orderByRaw(
                "CASE WHEN status = 'active' THEN 0 ELSE 1 END"
            )
            ->orderByDesc('prescription_date')
            ->get();

        return view(
            'staff.prescriptions.index',
            compact('prescriptions')
        );
    }

    /**
     * Display prescription details.
     */
    public function show(Prescription $prescription): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $prescription->load([
            'patient.user',
            'doctor.user',
            'consultation',
            'consultation.appointment.healthCenter',
            'items.medicine',
            'releasedBy',
        ]);

        if (
            !$prescription->consultation ||
            !$prescription->consultation->appointment ||
            $prescription->consultation->appointment->health_center_id
                !== $staff->health_center_id
        ) {
            abort(
                403,
                'You are not authorized to view this prescription.'
            );
        }

        return view(
            'staff.prescriptions.show',
            compact('prescription')
        );
    }

    /**
     * Release medicine.
     */
    public function release(
        Prescription $prescription
    ): RedirectResponse {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $prescription->load(
            'consultation.appointment'
        );

        if (
            !$prescription->consultation ||
            !$prescription->consultation->appointment ||
            $prescription->consultation->appointment->health_center_id
                !== $staff->health_center_id
        ) {
            abort(
                403,
                'You are not authorized to release this prescription.'
            );
        }

        if ($prescription->status !== 'active') {
            return redirect()
                ->route(
                    'staff.prescriptions.show',
                    $prescription
                )
                ->with(
                    'error',
                    'This prescription has already been released or is no longer active.'
                );
        }

        $prescription->update([
            'status' => 'released',
            'released_at' => now(),
            'released_by' => auth()->id(),
        ]);

        return redirect()
            ->route(
                'staff.prescriptions.show',
                $prescription
            )
            ->with(
                'success',
                'Medicine released successfully.'
            );
    }
}