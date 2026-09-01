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

        $appointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'healthCenter',
        ])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        return view('staff.dashboard', compact(
            'registeredPatients',
            'todayAppointments',
            'todayConsultations',
            'pendingRequests',
            'appointments'
        ));
    }
}