```blade
@extends('layouts.dashboard')

@section('title', 'Record Consultation')

@section('page-title', 'Record Consultation')

@section('content')

    <div class="dashboard-card">

        <div class="card-header">
            <div>
                <h3>Record Consultation</h3>
                <p>Enter the patient's consultation information</p>
            </div>

            <a href="{{ route('doctor.appointments.index') }}">
                Back to Appointments
            </a>
        </div>

        {{-- Patient Information --}}
        <div class="appointment-preview">

            <div class="appointment-date">
                <strong>
                    {{ $appointment->appointment_date->format('M') }}
                </strong>

                <span>
                    {{ $appointment->appointment_date->format('d') }}
                </span>
            </div>

            <div class="appointment-details">

                <h4>
                    {{ $appointment->patient->user->name ?? 'Patient' }}
                </h4>

                @if($appointment->patient)
                    <p>
                        Patient No:
                        {{ $appointment->patient->patient_number }}
                    </p>
                @endif

                <p>
                    🕐
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                </p>

                @if($appointment->healthCenter)
                    <p>
                        🏥
                        {{ $appointment->healthCenter->name }}
                    </p>
                @endif

                @if($appointment->reason)
                    <p>
                        Reason:
                        {{ $appointment->reason }}
                    </p>
                @endif

                <span class="appointment-status">
                    {{ ucfirst($appointment->status) }}
                </span>

            </div>

        </div>

        {{-- Validation Errors --}}
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

        {{-- Consultation Form --}}
        <form
            action="{{ route('doctor.appointments.consultation.store', $appointment) }}"
            method="POST"
        >

            @csrf

            <div class="form-group">
                <label for="chief_complaint">
                    Chief Complaint
                </label>

                <textarea
                    id="chief_complaint"
                    name="chief_complaint"
                    rows="4"
                    required
                    placeholder="Enter the patient's main complaint..."
                >{{ old('chief_complaint') }}</textarea>
            </div>

            <div class="form-group">
                <label for="symptoms">
                    Symptoms
                </label>

                <textarea
                    id="symptoms"
                    name="symptoms"
                    rows="4"
                    placeholder="Describe the patient's symptoms..."
                >{{ old('symptoms') }}</textarea>
            </div>

            <div class="form-group">
                <label for="diagnosis">
                    Diagnosis
                </label>

                <textarea
                    id="diagnosis"
                    name="diagnosis"
                    rows="4"
                    required
                    placeholder="Enter the diagnosis..."
                >{{ old('diagnosis') }}</textarea>
            </div>

            <div class="form-group">
                <label for="treatment_plan">
                    Treatment Plan
                </label>

                <textarea
                    id="treatment_plan"
                    name="treatment_plan"
                    rows="4"
                    placeholder="Enter the recommended treatment plan..."
                >{{ old('treatment_plan') }}</textarea>
            </div>

            <div class="form-group">
                <label for="notes">
                    Additional Notes
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Enter any additional notes..."
                >{{ old('notes') }}</textarea>
            </div>

            <div style="margin-top: 20px;">

                <button
                    type="submit"
                    class="primary-button"
                >
                    Save Consultation
                </button>

                <a
                    href="{{ route('doctor.appointments.index') }}"
                    style="margin-left: 10px;"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

@endsection
```
