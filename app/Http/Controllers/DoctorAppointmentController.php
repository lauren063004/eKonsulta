<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\View\View;

class DoctorAppointmentController extends Controller
{
    /**
     * Display appointments assigned to the logged-in doctor.
     */
    public function index(): View
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor record not found.');
        }

        $appointments = Appointment::with([
            'patient.user',
            'healthCenter',
        ])
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('doctor.appointments.index', compact(
            'appointments'
        ));
    }

    /**
     * Approve a pending appointment.
     */
    public function approve(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor record not found.');
        }

        // Make sure this appointment belongs to the logged-in doctor.
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403, 'You are not authorized to approve this appointment.');
        }

        // Only pending appointments can be approved.
        if ($appointment->status !== 'pending') {
            return redirect()
                ->route('doctor.appointments.index')
                ->with('error', 'Only pending appointments can be approved.');
        }

        $appointment->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('doctor.appointments.index')
            ->with('success', 'Appointment approved successfully.');
    }
}