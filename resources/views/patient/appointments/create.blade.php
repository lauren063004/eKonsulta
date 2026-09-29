@extends('layouts.dashboard')

@section('title', 'Book Appointment')

@section('page-title', 'Book Appointment')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Book an Appointment</h3>

            <p>
                Select a service, consultation schedule, and doctor.
            </p>
        </div>

        <a href="{{ route('patient.dashboard') }}">
            Back to Dashboard
        </a>

    </div>


    {{-- Validation Errors --}}
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


    <div class="reminder-box">
        <span aria-hidden="true">🕐</span>
        <span><strong>Reminder:</strong> Please arrive 15 minutes early before your appointment.</span>
    </div>


    {{-- STEP 1 — Assigned Health Center --}}
    <div class="form-section">

        <div class="form-section-head">
            <span class="step-number">1</span>
            <div>
                <h4>Health Center</h4>
                <p>Assigned from your registered barangay</p>
            </div>
        </div>

        <div class="form-group">

            <div class="center-card">
                <div class="center-icon" aria-hidden="true">🏥</div>

                <input
                    type="text"
                    value="{{ $healthCenter->name }} — {{ $healthCenter->barangay }}"
                    readonly
                    aria-label="Health Center"
                >
            </div>

            <small>
                Your health center is based on your registered barangay.
            </small>

        </div>

    </div>


    @if ($schedules->count() && $services->count())

        <form
            method="POST"
            action="{{ route('patient.appointments.store') }}"
        >

            @csrf


            {{-- STEP 2 — Service and Schedule --}}
            <div class="form-section">

                <div class="form-section-head">
                    <span class="step-number">2</span>
                    <div>
                        <h4>Service &amp; Schedule</h4>
                        <p>Choose the service, then an available date and time</p>
                    </div>
                </div>

                {{-- Service --}}
                <div class="form-group">

                    <label for="service_id">
                        Type of Service
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
                        Only services currently offered by your health center are shown.
                    </small>

                </div>


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
                                $available = max(
                                    $schedule->capacity - $booked,
                                    0
                                );
                            @endphp

                            <option
                                value="{{ $schedule->id }}"
                                data-health-center-id="{{ $schedule->health_center_id }}"
                                data-service-id="{{ $schedule->service_id }}"
                                {{ old('appointment_schedule_id') == $schedule->id ? 'selected' : '' }}
                            >

                                {{ $schedule->healthCenter->name }}
                                —
                                {{ $schedule->schedule_date->format('M d, Y') }}
                                —
                                {{ $schedule->appointment_time->format('h:i A') }}
                                —
                                {{ $available }}
                                slot{{ $available == 1 ? '' : 's' }}
                                available

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- STEP 3 — Doctor --}}
            <div class="form-section">

                <div class="form-section-head">
                    <span class="step-number">3</span>
                    <div>
                        <h4>Doctor</h4>
                        <p>Doctors available for your selected service and schedule</p>
                    </div>
                </div>

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
                                data-service-ids="{{ $doctor->services->pluck('id')->implode(',') }}"
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
                    class="form-group schedule-summary"
                    style="display: none;"
                >

                    <p>
                        <strong>Selected Schedule</strong>
                    </p>

                    <p id="schedule-details"></p>

                </div>

            </div>


            {{-- STEP 4 — Concern --}}
            <div class="form-section">

                <div class="form-section-head">
                    <span class="step-number">4</span>
                    <div>
                        <h4>Your Concern</h4>
                        <p>Help the doctor prepare for your visit</p>
                    </div>
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
                    Book Appointment
                </button>

            </div>

        </form>

    @elseif (!$services->count())

        <div class="alert alert-danger">

            <strong>No services are currently available.</strong>

            <p>
                Your assigned health center has not published any available services.
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

    @else

        <div class="alert alert-danger">

            <strong>No appointment schedules are currently available.</strong>

            <p>
                Please check again later when your health center publishes new consultation schedules.
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


{{-- JavaScript below is unchanged from your original --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const serviceSelect =
        document.getElementById('service_id');

    const scheduleSelect =
        document.getElementById('appointment_schedule_id');

    const doctorSelect =
        document.getElementById('doctor_id');

    const scheduleInfo =
        document.getElementById('schedule-info');

    const scheduleDetails =
        document.getElementById('schedule-details');

    if (
        !serviceSelect ||
        !scheduleSelect ||
        !doctorSelect
    ) {
        return;
    }

    const scheduleOptions = Array.from(
        scheduleSelect.querySelectorAll(
            'option[data-service-id]'
        )
    );

    const doctorOptions = Array.from(
        doctorSelect.querySelectorAll(
            'option[data-service-ids]'
        )
    );

    function updateSchedules() {

        const serviceId =
            serviceSelect.value;

        scheduleSelect.value = '';

        doctorSelect.value = '';
        doctorSelect.disabled = true;

        scheduleOptions.forEach(function (option) {

            const optionServiceId =
                option.dataset.serviceId;

            option.hidden =
                !serviceId ||
                optionServiceId !== serviceId;

        });

        const placeholder =
            scheduleSelect.querySelector(
                'option[value=""]'
            );

        if (placeholder) {

            placeholder.textContent =
                serviceId
                    ? 'Select an available schedule'
                    : 'Select a service first';

        }

        scheduleInfo.style.display =
            'none';

        updateDoctors();

    }

    function updateDoctors() {

        const serviceId =
            serviceSelect.value;

        const selectedSchedule =
            scheduleSelect.options[
                scheduleSelect.selectedIndex
            ];

        const healthCenterId =
            selectedSchedule?.dataset.healthCenterId || '';

        doctorSelect.value = '';

        if (!serviceId || !healthCenterId) {

            doctorSelect.disabled = true;

            const placeholder =
                doctorSelect.querySelector(
                    'option[value=""]'
                );

            if (placeholder) {
                placeholder.textContent =
                    !serviceId
                        ? 'Select a service first'
                        : 'Select a schedule first';
            }

            scheduleInfo.style.display =
                'none';

            return;
        }

        doctorSelect.disabled = false;

        doctorOptions.forEach(function (option) {

            const doctorHealthCenterId =
                option.dataset.healthCenterId;

            const serviceIds =
                option.dataset.serviceIds
                    ? option.dataset.serviceIds.split(',')
                    : [];

            const matchesHealthCenter =
                doctorHealthCenterId ===
                healthCenterId;

            const matchesService =
                serviceIds.includes(serviceId);

            option.hidden =
                !(
                    matchesHealthCenter &&
                    matchesService
                );

        });

        const placeholder =
            doctorSelect.querySelector(
                'option[value=""]'
            );

        if (placeholder) {
            placeholder.textContent =
                'Select a doctor';
        }

        scheduleInfo.style.display =
            'block';

        scheduleDetails.textContent =
            selectedSchedule.textContent.trim();
    }

    serviceSelect.addEventListener(
        'change',
        updateSchedules
    );

    scheduleSelect.addEventListener(
        'change',
        updateDoctors
    );

    updateSchedules();

});
</script>

@endsection