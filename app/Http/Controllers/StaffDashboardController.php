<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function index(): View
    {
        $today = now()->toDateString();

        $registeredPatients = Patient::count();

        $todayAppointments = Appointment::whereDate(
            'appointment_date',
            $today
        )->count();

        $todayConsultations = Consultation::whereDate(
            'consultation_date',
            $today
        )->count();

        $pendingRequests = Appointment::where('status', 'pending')
            ->count();

        /*
         * Today's appointments.
         */
        $appointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'healthCenter',
        ])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        /*
         * Upcoming appointments for the dashboard.
         *
         * Excludes cancelled and completed appointments.
         */
        $upcomingAppointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'healthCenter',
        ])
            ->whereDate('appointment_date', '>=', $today)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('staff.dashboard', compact(
            'registeredPatients',
            'todayAppointments',
            'todayConsultations',
            'pendingRequests',
            'appointments',
            'upcomingAppointments'
        ));
    }
}