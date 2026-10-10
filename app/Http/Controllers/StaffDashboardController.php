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
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $today = now()->toDateString();

        $registeredPatients = Patient::where(
            'health_center_id',
            $staff->health_center_id
        )->count();

        $todayAppointments = Appointment::whereDate(
            'appointment_date',
            $today
        )
            ->where('health_center_id', $staff->health_center_id)
            ->count();

        $todayConsultations = Consultation::whereDate(
            'consultation_date',
            $today
        )
            ->whereHas('appointment', function ($query) use ($staff) {
                $query->where('health_center_id', $staff->health_center_id);
            })
            ->count();

        $pendingRequests = Appointment::where('health_center_id', $staff->health_center_id)
            ->where('status', 'pending')
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
            ->where('health_center_id', $staff->health_center_id)
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
            ->where('health_center_id', $staff->health_center_id)
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