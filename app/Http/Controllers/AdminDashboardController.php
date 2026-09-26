<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\HealthCenter;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Staff;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalStaff = Staff::count();
        $totalHealthCenters = HealthCenter::count();
        $totalAppointments = Appointment::count();
        $totalConsultations = Consultation::count();
        $totalPrescriptions = Prescription::count();

        $recentActivityLogs = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPatients',
            'totalDoctors',
            'totalStaff',
            'totalHealthCenters',
            'totalAppointments',
            'totalConsultations',
            'totalPrescriptions',
            'recentActivityLogs'
        ));
    }
}