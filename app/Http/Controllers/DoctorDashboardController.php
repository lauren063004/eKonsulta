<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    /**
     * Display the doctor's dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $doctor = $user->doctor;

        if (!$doctor) {
            abort(403, 'Doctor record not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Doctor's Appointments
        |--------------------------------------------------------------------------
        */

        $appointments = Appointment::with([
            'patient.user',
            'healthCenter',
        ])
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Today's Appointments
        |--------------------------------------------------------------------------
        */

        $todayAppointments = $appointments
            ->filter(function ($appointment) {
                return $appointment->appointment_date
                    && $appointment->appointment_date->isToday()
                    && $appointment->status !== 'cancelled';
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Upcoming Appointments
        |--------------------------------------------------------------------------
        */

        $upcomingAppointments = $appointments
            ->filter(function ($appointment) {
                return $appointment->appointment_date
                    && (
                        $appointment->appointment_date->isToday()
                        || $appointment->appointment_date->isFuture()
                    );
            })
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Appointment Statistics
        |--------------------------------------------------------------------------
        */

        $totalAppointments = $appointments->count();

        $pendingAppointments = $appointments
            ->where('status', 'pending')
            ->count();

        $completedAppointments = $appointments
            ->where('status', 'completed')
            ->count();

        $cancelledAppointments = $appointments
            ->where('status', 'cancelled')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Consultation Statistics
        |--------------------------------------------------------------------------
        */

        $consultationCount = Consultation::where('doctor_id', $doctor->id)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Prescription Statistics
        |--------------------------------------------------------------------------
        */

        $prescriptionCount = Prescription::where('doctor_id', $doctor->id)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Unique Patients
        |--------------------------------------------------------------------------
        */

        $patientCount = $appointments
            ->pluck('patient_id')
            ->filter()
            ->unique()
            ->count();

        return view('doctor.dashboard', compact(
            'doctor',
            'appointments',
            'todayAppointments',
            'upcomingAppointments',
            'totalAppointments',
            'pendingAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'consultationCount',
            'prescriptionCount',
            'patientCount'
        ));
    }
}