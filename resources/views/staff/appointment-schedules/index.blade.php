@extends('layouts.dashboard')

@section('title', 'Appointment Schedules')

@section('content')

<div class="page-header">
    <div>
        <h1>Appointment Schedules</h1>
        <p>Manage available consultation schedules and appointment capacity.</p>
    </div>

    <a href="{{ route('staff.appointment-schedules.create') }}" class="btn btn-primary">
        + Create Schedule
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h2>Available Schedules</h2>
    </div>

    <div class="card-body">

        @if($schedules->count())

            <div class="table-responsive">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>Health Center</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Capacity</th>
                            <th>Booked</th>
                            <th>Available</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($schedules as $schedule)

                           @php
    $booked = (int) $schedule->active_appointments_count;
    $available = max($schedule->capacity - $booked, 0);
@endphp

                            <tr>

                                <td>
                                    {{ $schedule->healthCenter->name }}
                                </td>

                                <td>
                                    {{ $schedule->schedule_date->format('M d, Y') }}
                                </td>

                                <td>
                                    {{ $schedule->appointment_time->format('h:i A') }}
                                </td>

                                <td>
                                    {{ $schedule->capacity }}
                                </td>

                                <td>
                                    {{ $booked }}
                                </td>

                                <td>
                                    {{ $available }}
                                </td>

                                <td>

                                    @if($booked === 0)

                                        <form
                                            method="POST"
                                            action="{{ route('staff.appointment-schedules.destroy', $schedule) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this schedule?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    @else

                                        <span class="text-muted">
                                            Has appointments
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-state-icon">
                    📅
                </div>

                <h3>No appointment schedules yet</h3>

                <p>
                    Create an appointment schedule so patients can book available consultation slots.
                </p>

                <a
                    href="{{ route('staff.appointment-schedules.create') }}"
                    class="btn btn-primary"
                >
                    Create First Schedule
                </a>

            </div>

        @endif

    </div>

</div>

@endsection