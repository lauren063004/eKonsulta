<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\HealthCenter;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Staff;
use App\Models\User;
use Illuminate\View\View;

class AdminReportController extends Controller
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

        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        $activeHealthCenters = HealthCenter::where('status', 'active')->count();
        $inactiveHealthCenters = HealthCenter::where('status', 'inactive')->count();

        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $approvedAppointments = Appointment::where('status', 'approved')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalPatients',
            'totalDoctors',
            'totalStaff',
            'totalHealthCenters',
            'totalAppointments',
            'totalConsultations',
            'totalPrescriptions',
            'activeUsers',
            'inactiveUsers',
            'activeHealthCenters',
            'inactiveHealthCenters',
            'pendingAppointments',
            'approvedAppointments',
            'completedAppointments',
            'cancelledAppointments'
        ));
    }
}