@extends('layouts.dashboard')

@section('title', 'Create Appointment Schedule')

@section('content')

<div class="page-header">
    <div>
        <h1>Create Appointment Schedule</h1>
        <p>Create an available consultation time slot for your assigned health center.</p>
    </div>


<a
    href="{{ route('staff.appointment-schedules.index') }}"
    class="btn btn-secondary"
>
    ← Back to Schedules
</a>


</div>

@if($errors->any()) <div class="alert alert-danger"> <strong>Please correct the following:</strong>


    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>


@endif

@if(session('error')) <div class="alert alert-danger">
{{ session('error') }} </div>
@endif

<div class="card">


<div class="card-header">
    <h2>Schedule Details</h2>
</div>

<div class="card-body">

    <form
        method="POST"
        action="{{ route('staff.appointment-schedules.store') }}"
    >

        @csrf

        {{-- ASSIGNED HEALTH CENTER --}}

        <div class="form-group">

            <label for="health_center">
                Health Center
            </label>

            <input
                type="text"
                id="health_center"
                class="form-control"
                value="{{ $staff->healthCenter->name ?? 'Not assigned' }}"
                readonly
            >

            <small class="form-help">
                This schedule will automatically be created for your assigned health center.
            </small>

        </div>


        {{-- DATE AND TIME --}}

        <div class="form-row">

            <div class="form-group">

                <label for="schedule_date">
                    Schedule Date
                </label>

                <input
                    type="date"
                    name="schedule_date"
                    id="schedule_date"
                    class="form-control"
                    value="{{ old('schedule_date') }}"
                    min="{{ now()->toDateString() }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="appointment_time">
                    Appointment Time
                </label>

                <input
                    type="time"
                    name="appointment_time"
                    id="appointment_time"
                    class="form-control"
                    value="{{ old('appointment_time') }}"
                    required
                >

            </div>

        </div>


        {{-- CAPACITY --}}

        <div class="form-group">

            <label for="capacity">
                Appointment Capacity
            </label>

            <input
                type="number"
                name="capacity"
                id="capacity"
                class="form-control"
                value="{{ old('capacity', 1) }}"
                min="1"
                max="100"
                required
            >

            <small class="form-help">
                Maximum number of patients who can book this schedule.
            </small>

        </div>


        {{-- ACTIONS --}}

        <div class="form-actions">

            <a
                href="{{ route('staff.appointment-schedules.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Schedule
            </button>

        </div>

    </form>

</div>

</div>

@endsection
