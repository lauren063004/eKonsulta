<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\View\View;

class StaffAppointmentController extends Controller
{
    /**
     * Display appointments for the staff member's assigned
     * health center.
     */
    public function index(): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $appointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'healthCenter',
            'consultation',
            'patientIntake',
        ])
            ->where(
                'health_center_id',
                $staff->health_center_id
            )
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view(
            'staff.appointments.index',
            compact('appointments')
        );
    }


    /**
     * Display appointment details.
     */
    public function show(Appointment $appointment): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        /*
         * Prevent staff from viewing another
         * health center's appointment.
         */
        if (
            $appointment->health_center_id
            !== $staff->health_center_id
        ) {
            abort(
                403,
                'You are not authorized to view this appointment.'
            );
        }

        $appointment->load([
            'patient.user',
            'doctor.user',
            'healthCenter',
            'consultation',
            'consultation.prescriptions.items.medicine',
            'patientIntake.staff.user',
        ]);

        return view(
            'staff.appointments.show',
            compact('appointment')
        );
    }
}