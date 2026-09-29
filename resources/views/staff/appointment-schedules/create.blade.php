@extends('layouts.dashboard')

@section('title', 'Create Appointment Schedule')

@section('page-title', 'Create Appointment Schedule')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Create Appointment Schedules</h3>

            <p>
                Generate multiple appointment time slots for your assigned health center.
            </p>
        </div>

        <a href="{{ route('staff.appointment-schedules.index') }}">
            ← Back to Schedules
        </a>

    </div>


    {{-- Errors --}}

    @if ($errors->any())

        <div class="alert alert-danger" role="alert">

            <strong>Please correct the following:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- Success --}}

    @if (session('success'))

        <div class="alert alert-success" role="status">
            {{ session('success') }}
        </div>

    @endif


    <form
        method="POST"
        action="{{ route('staff.appointment-schedules.store') }}"
    >

        @csrf


        {{-- Section 1: Where and what --}}
        <div class="form-section">

            <div class="form-section-head">
                <span class="step-number">1</span>
                <div>
                    <h4>Health Center &amp; Service</h4>
                    <p>Schedules are created for your assigned health center</p>
                </div>
            </div>

            {{-- Health Center --}}

            <div class="form-group">

                <label>
                    Health Center
                </label>

                <input
                    type="text"
                    value="{{ $staff->healthCenter->barangay ?? '' }} / {{ $staff->healthCenter->name ?? '' }}"
                    readonly
                >

                <small>
                    This schedule will automatically be created for your assigned health center.
                </small>

            </div>


            {{-- Service --}}

            <div class="form-group">

                <label for="service_id">
                    Service
                </label>

                <select
                    id="service_id"
                    name="service_id"
                    required
                >

                    <option value="">
                        Select a service
                    </option>

                    @foreach ($services as $service)

                        <option
                            value="{{ $service->id }}"
                            {{ old('service_id') == $service->id ? 'selected' : '' }}
                        >
                            {{ $service->name }}
                        </option>

                    @endforeach

                </select>

                <small>
                    Patients will only be able to book this schedule when they select this service.
                </small>

            </div>

        </div>


        {{-- Section 2: When --}}
        <div class="form-section">

            <div class="form-section-head">
                <span class="step-number">2</span>
                <div>
                    <h4>Date &amp; Time</h4>
                    <p>Set the day and the operating hours</p>
                </div>
            </div>


            {{-- Date --}}

            <div class="form-group">

                <label for="schedule_date">
                    Schedule Date
                </label>

                <input
                    type="date"
                    id="schedule_date"
                    name="schedule_date"
                    value="{{ old('schedule_date') }}"
                    min="{{ today()->format('Y-m-d') }}"
                    required
                >

            </div>


            <div class="form-row">

                {{-- Start Time --}}

                <div class="form-group">

                    <label for="start_time">
                        Start Time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time', '08:00') }}"
                        required
                    >

                </div>


                {{-- End Time --}}

                <div class="form-group">

                    <label for="end_time">
                        End Time
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        value="{{ old('end_time', '17:00') }}"
                        required
                    >

                </div>

            </div>

        </div>


        {{-- Section 3: Slots --}}
        <div class="form-section">

            <div class="form-section-head">
                <span class="step-number">3</span>
                <div>
                    <h4>Slots &amp; Capacity</h4>
                    <p>How the day is divided and how many patients each slot accepts</p>
                </div>
            </div>


            <div class="form-row">

                {{-- Interval --}}

                <div class="form-group">

                    <label for="interval">
                        Appointment Interval
                    </label>

                    <select
                        id="interval"
                        name="interval"
                        required
                    >

                        <option
                            value="60"
                            {{ old('interval', '60') == '60' ? 'selected' : '' }}
                        >
                            Every 1 hour
                        </option>

                        <option
                            value="30"
                            {{ old('interval') == '30' ? 'selected' : '' }}
                        >
                            Every 30 minutes
                        </option>

                    </select>

                    <small>
                        Example: 1-hour interval creates 8:00 AM, 9:00 AM, 10:00 AM, etc.
                    </small>

                </div>


                {{-- Capacity --}}

                <div class="form-group">

                    <label for="capacity">
                        Appointment Capacity
                    </label>

                    <input
                        type="number"
                        id="capacity"
                        name="capacity"
                        value="{{ old('capacity', 10) }}"
                        min="1"
                        max="100"
                        required
                    >

                    <small>
                        Maximum number of patients who can book each time slot.
                    </small>

                </div>

            </div>


            {{-- Lunch Break --}}

            <div class="form-group">

                <label>

                    <input
                        type="checkbox"
                        name="include_lunch_break"
                        value="1"
                        {{ old('include_lunch_break') ? 'checked' : '' }}
                    >

                    Skip 12:00 PM – 1:00 PM lunch break

                </label>

            </div>

        </div>


        {{-- Preview --}}

        <div
            class="form-group preview-panel"
            id="schedule-preview"
        >

            <strong>
                Schedule Preview
            </strong>

            <p id="preview-text" style="margin: 6px 0 0;">
                Select your schedule details to see the generated time slots.
            </p>

            <ul id="preview-list"></ul>

        </div>


        {{-- Buttons --}}

        <div class="form-actions">

            <a
                href="{{ route('staff.appointment-schedules.index') }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                Create Schedules
            </button>

        </div>

    </form>

</div>


{{-- JavaScript below is unchanged from your original --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const interval = document.getElementById('interval');
    const capacity = document.getElementById('capacity');
    const lunch = document.querySelector(
        'input[name="include_lunch_break"]'
    );

    const previewText =
        document.getElementById('preview-text');

    const previewList =
        document.getElementById('preview-list');


    function formatTime(time) {

        const parts = time.split(':');

        let hour = parseInt(parts[0]);
        const minute = parts[1];

        const suffix =
            hour >= 12 ? 'PM' : 'AM';

        hour =
            hour % 12 || 12;

        return hour + ':' + minute + ' ' + suffix;
    }


    function updatePreview() {

        previewList.innerHTML = '';

        if (!startTime.value || !endTime.value) {

            previewText.textContent =
                'Select your schedule details to see the generated time slots.';

            return;
        }


        const startParts =
            startTime.value.split(':');

        const endParts =
            endTime.value.split(':');


        let start =
            parseInt(startParts[0]) * 60 +
            parseInt(startParts[1]);

        const end =
            parseInt(endParts[0]) * 60 +
            parseInt(endParts[1]);

        const step =
            parseInt(interval.value);


        if (start >= end) {

            previewText.textContent =
                'End time must be later than start time.';

            return;
        }


        let count = 0;


        while (start < end) {

            const slotEnd =
                start + step;

            if (slotEnd > end) {
                break;
            }


            /*
            |----------------------------------------------------------------------
            | Lunch Break
            |----------------------------------------------------------------------
            */

            if (
                lunch.checked &&
                start >= 720 &&
                start < 780
            ) {

                start += step;

                continue;
            }


            const hour =
                Math.floor(start / 60);

            const minute =
                start % 60;


            const time =
                String(hour).padStart(2, '0') +
                ':' +
                String(minute).padStart(2, '0');


            const li =
                document.createElement('li');

            li.textContent =
                formatTime(time) +
                ' — ' +
                (capacity.value || 0) +
                ' slots';


            previewList.appendChild(li);

            count++;

            start += step;
        }


        previewText.textContent =
            count +
            ' appointment slot' +
            (count === 1 ? '' : 's') +
            ' will be created.';
    }


    startTime.addEventListener(
        'change',
        updatePreview
    );

    endTime.addEventListener(
        'change',
        updatePreview
    );

    interval.addEventListener(
        'change',
        updatePreview
    );

    capacity.addEventListener(
        'input',
        updatePreview
    );

    lunch.addEventListener(
        'change',
        updatePreview
    );


    updatePreview();

});
</script>

@endsection