@extends('layouts.dashboard')

@section('title', 'Create Appointment Schedule')

@section('content')

<div class="page-header">
    <div>
        <h1>Create Appointment Schedule</h1>
        <p>Create an available consultation time slot for patients.</p>
    </div>

    <a
        href="{{ route('staff.appointment-schedules.index') }}"
        class="btn btn-secondary"
    >
        ← Back to Schedules
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following:</strong>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
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

            <div class="form-group">

                <label for="health_center_id">
                    Health Center
                </label>

                <select
                    name="health_center_id"
                    id="health_center_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Select Health Center
                    </option>

                    @foreach($healthCenters as $healthCenter)

                        <option
                            value="{{ $healthCenter->id }}"
                            {{ old('health_center_id') == $healthCenter->id ? 'selected' : '' }}
                        >
                            {{ $healthCenter->name }}
                        </option>

                    @endforeach

                </select>

            </div>


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
                    Maximum number of patients that can book this schedule.
                </small>

            </div>


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