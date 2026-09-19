<?php

namespace App\Http\Controllers;

use App\Models\HealthCenter;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminHealthCenterController extends Controller
{
    /**
     * Display all health centers.
     */
    public function index(): View
    {
        $healthCenters = HealthCenter::with([
            'doctors.user',
            'staff.user',
        ])
            ->orderBy('name')
            ->get();

        return view('admin.health-centers.index', compact(
            'healthCenters'
        ));
    }

    /**
     * Display health center details.
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

        return view('admin.health-centers.show', compact(
            'healthCenter'
        ));

    }
    public function toggleStatus(HealthCenter $healthCenter): RedirectResponse
{
    $healthCenter->status = $healthCenter->status === 'active'
        ? 'inactive'
        : 'active';

    $healthCenter->save();

    $message = $healthCenter->status === 'active'
        ? 'Health center activated successfully.'
        : 'Health center deactivated successfully.';

    return redirect()
        ->route('admin.health-centers.index')
        ->with('success', $message);
}
}