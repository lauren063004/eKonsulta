<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffAppointmentScheduleController extends Controller
{
    /**
     * Display appointment schedules for the logged-in staff member's
     * assigned health center.
     */
 public function index(): View
{
    $staff = auth()->user()->staff;

    if (!$staff) {
        abort(403, 'Staff record not found.');
    }

    $schedules = AppointmentSchedule::with('healthCenter')
        ->withCount([
            'appointments as active_appointments_count' => function ($query) {
                $query->whereIn('status', [
                    'pending',
                    'approved',
                ]);
            },
        ])
        ->where('health_center_id', $staff->health_center_id)
        ->orderBy('schedule_date')
        ->orderBy('appointment_time')
        ->get();

    return view(
        'staff.appointment-schedules.index',
        compact('schedules')
    );
}

    /**
     * Show create schedule form.
     */
    public function create(): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $staff->load('healthCenter');

        return view(
            'staff.appointment-schedules.create',
            compact('staff')
        );
    }

    /**
     * Store a new appointment schedule.
     */
    public function store(Request $request): RedirectResponse
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        if (!$staff->healthCenter) {
            return redirect()
                ->route('staff.appointment-schedules.index')
                ->with(
                    'error',
                    'You are not assigned to a health center.'
                );
        }

        if ($staff->healthCenter->status !== 'active') {
            return redirect()
                ->route('staff.appointment-schedules.index')
                ->with(
                    'error',
                    'Your assigned health center is currently inactive.'
                );
        }

        $validated = $request->validate([
            'schedule_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $exists = AppointmentSchedule::where(
                'health_center_id',
                $staff->health_center_id
            )
            ->whereDate(
                'schedule_date',
                $validated['schedule_date']
            )
            ->where(
                'appointment_time',
                $validated['appointment_time']
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                        'A schedule already exists for your health center, date, and time.',
                ]);
        }

        AppointmentSchedule::create([
            'health_center_id' => $staff->health_center_id,
            'schedule_date' => $validated['schedule_date'],
            'appointment_time' => $validated['appointment_time'],
            'capacity' => $validated['capacity'],
        ]);

        return redirect()
            ->route('staff.appointment-schedules.index')
            ->with(
                'success',
                'Appointment schedule created successfully.'
            );
    }

    /**
     * Delete an appointment schedule.
     */
    public function destroy(
        AppointmentSchedule $appointmentSchedule
    ): RedirectResponse {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        // Prevent staff from deleting another health center's schedule.
        if (
            $appointmentSchedule->health_center_id
            !== $staff->health_center_id
        ) {
            abort(
                403,
                'You are not authorized to manage this schedule.'
            );
        }

        if (
            $appointmentSchedule->appointments()
                ->whereIn('status', ['pending', 'approved'])
                ->exists()
        ) {
            return redirect()
                ->route('staff.appointment-schedules.index')
                ->with(
                    'error',
                    'This schedule cannot be deleted because it already has appointments.'
                );
        }

        $appointmentSchedule->delete();

        return redirect()
            ->route('staff.appointment-schedules.index')
            ->with(
                'success',
                'Appointment schedule deleted successfully.'
            );
    }
}
