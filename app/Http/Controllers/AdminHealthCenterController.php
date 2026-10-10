<?php

namespace App\Http\Controllers;

use App\Models\HealthCenter;
use App\Models\Service;
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

    public function destroy(HealthCenter $healthCenter): \Illuminate\Http\RedirectResponse
    {
        try {
            $deleted = \Illuminate\Support\Facades\DB::transaction(function () use ($healthCenter): bool {
                $center = HealthCenter::query()
                    ->whereKey($healthCenter->getKey())
                    ->lockForUpdate()
                    ->firstOrFail();

                $hasLinkedRecords = $center->patients()->exists()
                    || $center->doctors()->exists()
                    || $center->staff()->exists()
                    || $center->appointments()->exists()
                    || \App\Models\Medicine::query()
                        ->where('health_center_id', $center->id)
                        ->exists()
                    || \App\Models\AppointmentSchedule::query()
                        ->where('health_center_id', $center->id)
                        ->exists()
                    || $center->services()->exists()
                    || $center->announcements()->exists();

                if ($hasLinkedRecords) {
                    return false;
                }

                $center->delete();

                return true;
            });
        } catch (\Illuminate\Database\QueryException $exception) {
            if (!in_array($exception->getCode(), ['23000', '23503'], true)) {
                throw $exception;
            }

            \Illuminate\Support\Facades\Log::warning(
                'Health center deletion was blocked by linked records.',
                [
                    'health_center_id' => $healthCenter->getKey(),
                    'exception' => $exception->getMessage(),
                ]
            );

            return redirect()
                ->route('admin.health-centers.index')
                ->withErrors([
                    'health_center' => 'This health center still has linked records. Deactivate it instead of deleting it.',
                ]);
        }

        if (!$deleted) {
            return redirect()
                ->route('admin.health-centers.index')
                ->withErrors([
                    'health_center' => 'This health center still has linked records. Deactivate it instead of deleting it.',
                ]);
        }

        return redirect()
            ->route('admin.health-centers.index')
            ->with('success', 'Health center deleted successfully.');
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
    'services',
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
            'barangay' => [
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
        $services = Service::where('status', true)
            ->orderBy('name')
            ->get();

        $healthCenter->load('services');

        return view(
            'admin.health-centers.edit',
            compact('healthCenter', 'services')
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
            'barangay' => [
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
            'services' => [
                'nullable',
                'array',
            ],
            'services.*' => [
                'integer',
                'exists:services,id',
            ],
        ]);

        $healthCenter->update([
            'name' => $validated['name'],
            'barangay' => $validated['barangay'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'] ?? null,
            'email' => $validated['email'] ?? null,
            'operating_hours' => $validated['operating_hours'] ?? null,
        ]);

        $healthCenter->services()->sync(
            $validated['services'] ?? []
        );

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