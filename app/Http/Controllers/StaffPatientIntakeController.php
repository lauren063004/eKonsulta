<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PatientIntake;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffPatientIntakeController extends Controller
{
    public function create(Appointment $appointment): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        // Staff can only handle appointments
        // belonging to their health center.
        if ($appointment->health_center_id !== $staff->health_center_id) {
            abort(
                403,
                'You are not authorized to access this appointment.'
            );
        }

        $appointment->load([
            'patient.user',
            'doctor.user',
            'healthCenter',
            'patientIntake',
        ]);

        return view(
            'staff.appointments.intake',
            compact('appointment')
        );
    }

    public function store(
        Request $request,
        Appointment $appointment
    ): RedirectResponse {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        // Make sure this appointment belongs
        // to the staff member's health center.
        if ($appointment->health_center_id !== $staff->health_center_id) {
            abort(
                403,
                'You are not authorized to update this appointment.'
            );
        }

        $validated = $request->validate([
            'height' => [
                'nullable',
                'numeric',
                'min:1',
                'max:300',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:1',
                'max:500',
            ],

            'comorbidities' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'maintenance_medications' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'allergies' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'has_diabetes' => [
                'nullable',
                'boolean',
            ],

            'has_hypertension' => [
                'nullable',
                'boolean',
            ],

            'other_medical_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        PatientIntake::updateOrCreate(
            [
                'appointment_id' => $appointment->id,
            ],
            [
                'patient_id' => $appointment->patient_id,
                'staff_id' => $staff->id,

                'height' => $validated['height'] ?? null,
                'weight' => $validated['weight'] ?? null,

                'comorbidities' =>
                    $validated['comorbidities'] ?? null,

                'maintenance_medications' =>
                    $validated['maintenance_medications'] ?? null,

                'allergies' =>
                    $validated['allergies'] ?? null,

                'has_diabetes' =>
                    $request->boolean('has_diabetes'),

                'has_hypertension' =>
                    $request->boolean('has_hypertension'),

                'other_medical_information' =>
                    $validated['other_medical_information'] ?? null,

                'completed_at' => now(),
            ]
        );

        return redirect()
            ->route('staff.appointments.show', $appointment)
            ->with(
                'success',
                'Patient intake completed successfully.'
            );
    }
}