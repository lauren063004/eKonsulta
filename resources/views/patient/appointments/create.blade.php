@extends('layouts.dashboard')

@section('title', 'Book Appointment')

@section('page-title', 'Book Appointment')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Book an Appointment</h3>

            <p>
                Select an available consultation schedule and doctor.
            </p>
        </div>

        <a href="{{ route('patient.dashboard') }}">
            Back to Dashboard
        </a>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    @if ($schedules->count())

        <form
            method="POST"
            action="{{ route('patient.appointments.store') }}"
        >

            @csrf


            {{-- Appointment Schedule --}}
            <div class="form-group">

                <label for="appointment_schedule_id">
                    Available Schedule
                </label>

                <select
                    id="appointment_schedule_id"
                    name="appointment_schedule_id"
                    required
                >

                    <option value="">
                        Select an available schedule
                    </option>

                    @foreach ($schedules as $schedule)

                        @php
                            $booked = $schedule->active_appointments_count;
                            $available = max($schedule->capacity - $booked, 0);
                        @endphp

                        <option
                            value="{{ $schedule->id }}"
                            data-health-center-id="{{ $schedule->health_center_id }}"
                            {{ old('appointment_schedule_id') == $schedule->id ? 'selected' : '' }}
                        >

                            {{ $schedule->healthCenter->name }}
                            —
                            {{ $schedule->schedule_date->format('M d, Y') }}
                            —
                            {{ $schedule->appointment_time->format('h:i A') }}
                            —
                            {{ $available }} slot{{ $available == 1 ? '' : 's' }} available

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Doctor --}}
            <div class="form-group">

                <label for="doctor_id">
                    Doctor
                </label>

                <select
                    id="doctor_id"
                    name="doctor_id"
                    required
                    disabled
                >

                    <option value="">
                        Select a schedule first
                    </option>

                    @foreach ($doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            data-health-center-id="{{ $doctor->health_center_id }}"
                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                        >

                            {{ $doctor->user->name ?? 'Doctor' }}

                            @if ($doctor->specialization)
                                — {{ $doctor->specialization }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Selected Schedule Information --}}
            <div
                id="schedule-info"
                class="form-group"
                style="display: none;"
            >

                <p>
                    <strong>Selected Schedule</strong>
                </p>

                <p id="schedule-details"></p>

            </div>


            {{-- Reason --}}
            <div class="form-group">

                <label for="reason">
                    Reason for Consultation
                </label>

                <textarea
                    id="reason"
                    name="reason"
                    rows="4"
                    placeholder="Briefly describe the reason for your appointment..."
                    required
                >{{ old('reason') }}</textarea>

            </div>


            {{-- Additional Notes --}}
            <div class="form-group">

                <label for="notes">
                    Additional Notes
                    <span>(Optional)</span>
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    placeholder="Any additional information for the doctor..."
                >{{ old('notes') }}</textarea>

            </div>


            {{-- Buttons --}}
            <div class="form-actions">

                <a
                    href="{{ route('patient.dashboard') }}"
                    class="secondary-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="primary-button"
                >
                    📅 Book Appointment
                </button>

            </div>

        </form>

    @else

        <div class="alert alert-danger">

            <strong>No appointment schedules are currently available.</strong>

            <p>
                Please check again later when the health center publishes new consultation schedules.
            </p>

        </div>

        <div class="form-actions">

            <a
                href="{{ route('patient.dashboard') }}"
                class="secondary-button"
            >
                Back to Dashboard
            </a>

        </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const scheduleSelect = document.getElementById('appointment_schedule_id');
    const doctorSelect = document.getElementById('doctor_id');
    const scheduleInfo = document.getElementById('schedule-info');
    const scheduleDetails = document.getElementById('schedule-details');

    if (!scheduleSelect || !doctorSelect) {
        return;
    }

    const doctorOptions = Array.from(
        doctorSelect.querySelectorAll('option[data-health-center-id]')
    );

    function updateDoctors() {

        const selectedOption =
            scheduleSelect.options[scheduleSelect.selectedIndex];

        const healthCenterId =
            selectedOption?.dataset.healthCenterId || '';

        doctorSelect.disabled = !healthCenterId;

        doctorSelect.value = '';

        doctorOptions.forEach(function (option) {

            option.hidden =
                option.dataset.healthCenterId !== healthCenterId;

        });

        if (!healthCenterId) {

            doctorSelect.value = '';

            const placeholder =
                doctorSelect.querySelector('option[value=""]');

            if (placeholder) {
                placeholder.textContent =
                    'Select a schedule first';
            }

            scheduleInfo.style.display = 'none';

            return;
        }

        const placeholder =
            doctorSelect.querySelector('option[value=""]');

        if (placeholder) {
            placeholder.textContent =
                'Select a doctor';
        }

        scheduleInfo.style.display = 'block';

        scheduleDetails.textContent =
            selectedOption.textContent.trim();
    }

    scheduleSelect.addEventListener('change', updateDoctors);

    updateDoctors();
});
</script>

@endsection