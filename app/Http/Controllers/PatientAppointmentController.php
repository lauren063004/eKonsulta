<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\HealthCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAppointmentController extends Controller
{
    /**
     * Display the patient's appointments.
     */
    public function index()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        $appointments = Appointment::with([
            'doctor.user',
            'healthCenter',
        ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        return view('patient.appointments.index', compact(
            'appointments'
        ));
    }

    /**
     * Show the appointment booking form.
     */
    public function create()
    {
        $healthCenters = HealthCenter::where('status', 'active')
            ->orderBy('name')
            ->get();

        $doctors = Doctor::with('user')
            ->orderBy('id')
            ->get();

        return view('patient.appointments.create', compact(
            'healthCenters',
            'doctors'
        ));
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'health_center_id' => ['required', 'exists:health_centers,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'reason' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'health_center_id' => $request->health_center_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Appointment booked successfully.');
    }

    /**
     * Cancel a patient's appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        // Make sure this appointment belongs to the logged-in patient.
        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'You are not authorized to cancel this appointment.');
        }

        // Only pending appointments can be cancelled.
        if ($appointment->status !== 'pending') {
            return redirect()
                ->route('patient.appointments.index')
                ->with('error', 'This appointment can no longer be cancelled.');
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('patient.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}