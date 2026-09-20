<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSchedule;
use App\Models\HealthCenter;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffAppointmentScheduleController extends Controller
{
    public function index(): View
    {
        $schedules = AppointmentSchedule::with('healthCenter')
            ->withCount('appointments')
            ->orderBy('schedule_date')
            ->orderBy('appointment_time')
            ->get();

        return view('staff.appointment-schedules.index', compact('schedules'));
    }

    public function create(): View
    {
        $healthCenters = HealthCenter::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('staff.appointment-schedules.create', compact('healthCenters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'health_center_id' => [
                'required',
                'exists:health_centers,id',
            ],
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

        $exists = AppointmentSchedule::where('health_center_id', $validated['health_center_id'])
            ->whereDate('schedule_date', $validated['schedule_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'A schedule already exists for this health center, date, and time.',
                ]);
        }

        AppointmentSchedule::create($validated);

        return redirect()
            ->route('staff.appointment-schedules.index')
            ->with('success', 'Appointment schedule created successfully.');
    }

    public function destroy(AppointmentSchedule $appointmentSchedule): RedirectResponse
    {
        if (
    $appointmentSchedule->appointments()
        ->whereIn('status', ['pending', 'approved'])
        ->exists()
) {
            return redirect()
                ->route('staff.appointment-schedules.index')
                ->with('error', 'This schedule cannot be deleted because it already has appointments.');
        }

        $appointmentSchedule->delete();

        return redirect()
            ->route('staff.appointment-schedules.index')
            ->with('success', 'Appointment schedule deleted successfully.');
    }
}