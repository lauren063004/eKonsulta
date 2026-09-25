<?php

namespace App\Http\Controllers;

use App\Models\HealthCenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    /**
     * Show the form for creating a health center.
     */
    public function create(): View
    {
        return view('admin.health-centers.create');
    }

    /**
     * Store a newly created health center.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'contact_number' => [
                'nullable',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'operating_hours' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $validated['status'] = 'active';

        HealthCenter::create($validated);

        return redirect()
            ->route('admin.health-centers.index')
            ->with(
                'success',
                'Health center added successfully.'
            );
    }

    /**
     * Show the form for editing a health center.
     */
    public function edit(HealthCenter $healthCenter): View
    {
        return view(
            'admin.health-centers.edit',
            compact('healthCenter')
        );
    }

    /**
     * Update an existing health center.
     */
    public function update(
        Request $request,
        HealthCenter $healthCenter
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'contact_number' => [
                'nullable',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'operating_hours' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $healthCenter->update($validated);

        return redirect()
            ->route(
                'admin.health-centers.show',
                $healthCenter
            )
            ->with(
                'success',
                'Health center updated successfully.'
            );
    }

    /**
     * Activate or deactivate a health center.
     */
    public function toggleStatus(
        HealthCenter $healthCenter
    ): RedirectResponse {
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