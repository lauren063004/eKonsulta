<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\HealthCenter;
use App\Models\Patient;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalHealthCenters = HealthCenter::count();
        $totalAppointments = Appointment::count();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalHealthCenters',
            'totalAppointments'
        ));
    }
}