<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientAppointmentController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        $appointments = Appointment::with([
            'doctor.user',
            'healthCenter',
            'appointmentSchedule',
        ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $schedules = AppointmentSchedule::with('healthCenter')
            ->withCount([
                'appointments as active_appointments_count' => function ($query) {
                    $query->whereIn('status', ['pending', 'approved']);
                },
            ])
            ->whereDate('schedule_date', '>=', today())
            ->whereHas('healthCenter', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('schedule_date')
            ->orderBy('appointment_time')
            ->get()
            ->filter(function ($schedule) {
                return $schedule->active_appointments_count < $schedule->capacity;
            });

        $doctors = Doctor::with('user')
            ->orderBy('id')
            ->get();

        return view('patient.appointments.create', compact(
            'schedules',
            'doctors'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_schedule_id' => [
                'required',
                'exists:appointment_schedules,id',
            ],
            'doctor_id' => [
                'required',
                'exists:doctors,id',
            ],
            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        try {

            DB::transaction(function () use ($validated, $patient) {

                $schedule = AppointmentSchedule::with('healthCenter')
                    ->lockForUpdate()
                    ->findOrFail($validated['appointment_schedule_id']);

                if (
                    !$schedule->healthCenter ||
                    $schedule->healthCenter->status !== 'active'
                ) {
                    throw new \RuntimeException(
                        'The selected health center is not currently active.'
                    );
                }

                $scheduleDate = $schedule->schedule_date->format('Y-m-d');
                $scheduleTime = $schedule->appointment_time->format('H:i:s');

                if (
                    $scheduleDate < now()->toDateString()
                    ||
                    (
                        $scheduleDate === now()->toDateString()
                        &&
                        $scheduleTime <= now()->format('H:i:s')
                    )
                ) {
                    throw new \RuntimeException(
                        'The selected appointment schedule is no longer available.'
                    );
                }

                $activeAppointments = $schedule->appointments()
                    ->whereIn('status', ['pending', 'approved'])
                    ->count();

                if ($activeAppointments >= $schedule->capacity) {
                    throw new \RuntimeException(
                        'The selected appointment schedule is already full.'
                    );
                }

                $doctor = Doctor::findOrFail($validated['doctor_id']);

                if (
                    (int) $doctor->health_center_id !==
                    (int) $schedule->health_center_id
                ) {
                    throw new \RuntimeException(
                        'The selected doctor is not assigned to the selected health center.'
                    );
                }

                $alreadyBooked = $schedule->appointments()
                    ->where('patient_id', $patient->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

                if ($alreadyBooked) {
                    throw new \RuntimeException(
                        'You already have an active appointment for this schedule.'
                    );
                }

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'health_center_id' => $schedule->health_center_id,
                    'appointment_schedule_id' => $schedule->id,
                    'appointment_date' => $schedule->schedule_date->format('Y-m-d'),
                    'appointment_time' => $schedule->appointment_time->format('H:i:s'),
                    'reason' => $validated['reason'],
                    'status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                ]);
            });

        } catch (\RuntimeException $e) {

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'appointment_schedule_id' => $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Appointment booked successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient record not found.');
        }

        if ($appointment->patient_id !== $patient->id) {
            abort(
                403,
                'You are not authorized to cancel this appointment.'
            );
        }

        if ($appointment->status !== 'pending') {
            return redirect()
                ->route('patient.appointments.index')
                ->with(
                    'error',
                    'This appointment can no longer be cancelled.'
                );
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('patient.appointments.index')
            ->with(
                'success',
                'Appointment cancelled successfully.'
            );
    }
}