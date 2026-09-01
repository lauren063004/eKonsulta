@extends('layouts.dashboard')

@section('title', 'Book Appointment')

@section('page-title', 'Book Appointment')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Book an Appointment</h3>

            <p>
                Schedule a consultation with one of our doctors.
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


    <form
        method="POST"
        action="{{ route('patient.appointments.store') }}"
    >

        @csrf


        {{-- Health Center --}}
        <div class="form-group">

            <label for="health_center_id">
                Health Center
            </label>

            <select
                id="health_center_id"
                name="health_center_id"
                required
            >

                <option value="">
                    Select a health center
                </option>

                @foreach ($healthCenters as $healthCenter)

                    <option
                        value="{{ $healthCenter->id }}"
                        {{ old('health_center_id') == $healthCenter->id ? 'selected' : '' }}
                    >
                        {{ $healthCenter->name }}
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
            >

                <option value="">
                    Select a doctor
                </option>

                @foreach ($doctors as $doctor)

                    <option
                        value="{{ $doctor->id }}"
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


        {{-- Appointment Date --}}
        <div class="form-group">

            <label for="appointment_date">
                Appointment Date
            </label>

            <input
                type="date"
                id="appointment_date"
                name="appointment_date"
                value="{{ old('appointment_date') }}"
                min="{{ date('Y-m-d') }}"
                required
            >

        </div>


        {{-- Appointment Time --}}
        <div class="form-group">

            <label for="appointment_time">
                Appointment Time
            </label>

            <input
                type="time"
                id="appointment_time"
                name="appointment_time"
                value="{{ old('appointment_time') }}"
                required
            >

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

</div>

@endsection