<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffAppointmentScheduleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List Appointment Schedules
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $schedules = AppointmentSchedule::with([
            'healthCenter',
            'service',
            'doctor.user',
        ])
            ->withCount([
                'appointments as active_appointments_count' => function ($query) {
                    $query->whereIn('status', [
                        'pending',
                        'approved',
                    ]);
                },
            ])
            ->where(
                'health_center_id',
                $staff->health_center_id
            )
            ->orderBy('schedule_date')
            ->orderBy('appointment_time')
            ->get();

        return view(
            'staff.appointment-schedules.index',
            compact('schedules')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Schedule Form
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }

        $staff->load([
            'healthCenter',
        ]);

        if (!$staff->healthCenter) {
            abort(
                403,
                'You are not assigned to a health center.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Services Available At Staff's Health Center
        |--------------------------------------------------------------------------
        */

        $services = $staff->healthCenter
            ->services()
            ->where('services.status', true)
            ->with([
                'doctors' => function ($query) use ($staff) {
                    $query
                        ->where(
                            'doctors.health_center_id',
                            $staff->health_center_id
                        )
                      ->whereHas('user', function ($userQuery) {
    $userQuery->where('status', 'active');
})
                        ->with('user')
                        ->orderBy('doctors.id');
                },
            ])
            ->orderBy('services.name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Prepare Service → Doctor Data For Blade
        |--------------------------------------------------------------------------
        */

        $servicesData = $services
            ->mapWithKeys(function ($service) {

                return [
                    $service->id => $service->doctors
                        ->map(function ($doctor) {

                            return [
                                'id' => $doctor->id,
                                'name' => $doctor->user->name ?? 'Doctor',
                            ];

                        })
                        ->values()
                        ->toArray(),
                ];

            })
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Return Create Schedule View
        |--------------------------------------------------------------------------
        */

        return view(
            'staff.appointment-schedules.create',
            compact(
                'staff',
                'services',
                'servicesData'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Appointment Schedules
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Verify Staff Health Center
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Validate Form
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'doctor_id' => [
                'required',
                'integer',
                'exists:doctors,id',
            ],

            'schedule_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
            ],

            'interval' => [
                'required',
                'integer',
                'in:30,60',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'include_lunch_break' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Verify Service Belongs To Staff's Health Center
        |--------------------------------------------------------------------------
        */

        $serviceExists = $staff->healthCenter
            ->services()
            ->where(
                'services.id',
                $validated['service_id']
            )
            ->where(
                'services.status',
                true
            )
            ->exists();

        if (!$serviceExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'service_id' =>
                        'The selected service is not available at your health center.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify Doctor Belongs To Staff's Health Center
        |--------------------------------------------------------------------------
        */

        $doctor = $staff->healthCenter
            ->doctors()
            ->where(
                'doctors.id',
                $validated['doctor_id']
            )
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->first();

        if (!$doctor) {

            return back()
                ->withInput()
                ->withErrors([
                    'doctor_id' =>
                        'The selected doctor is not available at your health center.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify Doctor Provides Selected Service
        |--------------------------------------------------------------------------
        */

        $doctorProvidesService = $doctor
            ->services()
            ->where(
                'services.id',
                $validated['service_id']
            )
            ->where(
                'services.status',
                true
            )
            ->exists();

        if (!$doctorProvidesService) {

            return back()
                ->withInput()
                ->withErrors([
                    'doctor_id' =>
                        'The selected doctor does not provide the selected service.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Time Range
        |--------------------------------------------------------------------------
        */

        if (
            $validated['start_time'] >=
            $validated['end_time']
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'end_time' =>
                        'The end time must be later than the start time.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Time Slots
        |--------------------------------------------------------------------------
        */

        $start = strtotime(
            $validated['start_time']
        );

        $end = strtotime(
            $validated['end_time']
        );

        $intervalSeconds =
            ((int) $validated['interval']) * 60;

        $created = 0;
        $skipped = 0;


        /*
        |--------------------------------------------------------------------------
        | Optional Lunch Break
        |--------------------------------------------------------------------------
        */

        $includeLunch =
            $request->boolean('include_lunch_break');


        while ($start < $end) {

            $currentTime =
                date('H:i', $start);


            /*
            |--------------------------------------------------------------------------
            | Skip Lunch Hour
            |--------------------------------------------------------------------------
            */

            if (
                $includeLunch &&
                $currentTime >= '12:00' &&
                $currentTime < '13:00'
            ) {

                $start += $intervalSeconds;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Slot From Extending Beyond End Time
            |--------------------------------------------------------------------------
            */

            $slotEnd =
                $start + $intervalSeconds;

            if ($slotEnd > $end) {
                break;
            }


            /*
            |--------------------------------------------------------------------------
            | Check Existing Schedule
            |--------------------------------------------------------------------------
            */

            $exists = AppointmentSchedule::where(
                'health_center_id',
                $staff->health_center_id
            )
                ->where(
                    'service_id',
                    $validated['service_id']
                )
                ->where(
                    'doctor_id',
                    $validated['doctor_id']
                )
                ->whereDate(
                    'schedule_date',
                    $validated['schedule_date']
                )
                ->where(
                    'appointment_time',
                    $currentTime . ':00'
                )
                ->exists();


            if ($exists) {

                $skipped++;

            } else {

                AppointmentSchedule::create([

                    'health_center_id' =>
                        $staff->health_center_id,

                    'service_id' =>
                        $validated['service_id'],

                    'doctor_id' =>
                        $validated['doctor_id'],

                    'schedule_date' =>
                        $validated['schedule_date'],

                    'appointment_time' =>
                        $currentTime . ':00',

                    'capacity' =>
                        $validated['capacity'],

                ]);

                $created++;
            }


            /*
            |--------------------------------------------------------------------------
            | Move To Next Time Slot
            |--------------------------------------------------------------------------
            */

            $start += $intervalSeconds;
        }


        /*
        |--------------------------------------------------------------------------
        | Result Message
        |--------------------------------------------------------------------------
        */

        if ($created === 0) {

            return redirect()
                ->route(
                    'staff.appointment-schedules.index'
                )
                ->with(
                    'error',
                    'No new schedules were created. The selected doctor, service, and time slots already exist.'
                );
        }


        $message =
            $created .
            ' appointment schedule' .
            ($created === 1 ? '' : 's') .
            ' created successfully.';


        if ($skipped > 0) {

            $message .=
                ' ' .
                $skipped .
                ' existing slot' .
                ($skipped === 1 ? '' : 's') .
                ' skipped.';
        }


        return redirect()
            ->route(
                'staff.appointment-schedules.index'
            )
            ->with(
                'success',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Appointment Schedule
    |--------------------------------------------------------------------------
    */

    public function destroy(
        AppointmentSchedule $appointmentSchedule
    ): RedirectResponse {

        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'Staff record not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if (
            $appointmentSchedule->health_center_id
            !== $staff->health_center_id
        ) {

            abort(
                403,
                'You are not authorized to manage this schedule.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Don't Delete Schedule With Active Appointments
        |--------------------------------------------------------------------------
        */

        if (
            $appointmentSchedule
                ->appointments()
                ->whereIn(
                    'status',
                    [
                        'pending',
                        'approved',
                    ]
                )
                ->exists()
        ) {

            return redirect()
                ->route(
                    'staff.appointment-schedules.index'
                )
                ->with(
                    'error',
                    'This schedule cannot be deleted because it already has appointments.'
                );
        }


        $appointmentSchedule->delete();


        return redirect()
            ->route(
                'staff.appointment-schedules.index'
            )
            ->with(
                'success',
                'Appointment schedule deleted successfully.'
            );
    }
}
