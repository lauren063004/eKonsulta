<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffAppointmentController extends Controller
{
    /**
     * Display all appointments for staff.
     */
    public function index(): View
    {
        $appointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'healthCenter',
            'consultation',
        ])
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('staff.appointments.index', compact(
            'appointments'
        ));
    }

    /**
     * Display appointment details.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load([
            'patient.user',
            'doctor.user',
            'healthCenter',
            'consultation',
            'consultation.prescriptions.items.medicine',
        ]);

        return view('staff.appointments.show', compact(
            'appointment'
        ));
    }

    /**
     * Approve a pending appointment.
     */
    public function approve(Appointment $appointment): RedirectResponse
    {
        if ($appointment->status !== 'pending') {
            return redirect()
                ->route('staff.appointments.index')
                ->with('error', 'Only pending appointments can be approved.');
        }

        $appointment->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('staff.appointments.index')
            ->with('success', 'Appointment approved successfully.');
    }

    /**
     * Cancel a pending appointment.
     */
    public function cancel(Appointment $appointment): RedirectResponse
    {
        if ($appointment->status !== 'pending') {
            return redirect()
                ->route('staff.appointments.index')
                ->with('error', 'Only pending appointments can be cancelled.');
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('staff.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}