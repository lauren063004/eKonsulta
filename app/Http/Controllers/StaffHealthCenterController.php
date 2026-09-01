<?php

namespace App\Http\Controllers;

use App\Models\HealthCenter;
use Illuminate\View\View;

class StaffHealthCenterController extends Controller
{
    /**
     * Display health center information for staff.
     */
    public function index(): View
    {
        $healthCenters = HealthCenter::with([
            'doctors.user',
            'staff.user',
        ])
            ->orderBy('name')
            ->get();

        return view('staff.health-centers.index', compact(
            'healthCenters'
        ));
    }

    /**
     * Display a health center's details.
     */
    public function show(HealthCenter $healthCenter): View
    {
        $healthCenter->load([
            'doctors.user',
            'staff.user',
            'appointments.patient.user',
            'appointments.doctor.user',
            'medicines',
        ]);

        return view('staff.health-centers.show', compact(
            'healthCenter'
        ));
    }
}