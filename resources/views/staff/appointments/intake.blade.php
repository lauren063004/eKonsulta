@extends('layouts.dashboard')

@section('title', 'Patient Intake')

@section('page-title', 'Patient Intake')

@section('content')

<div class="dashboard-card clinical-workspace staff-intake-page">

    <div class="card-header">

        <div>
            <h3>Patient Intake</h3>
            <p>
                Record the patient's initial health information
                before consultation.
            </p>
        </div>

        <a
            href="{{ route('staff.appointments.show', $appointment) }}"
            class="secondary-button"
        >
            Back to Appointment
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


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


    {{-- Patient Information --}}
    <div class="intake-section intake-patient-summary">

        <h3>👤 Patient Information</h3>

        <div class="appointment-details">

            <p>
                <strong>Name:</strong>
                {{ $appointment->patient->user->name ?? 'Patient' }}
            </p>

            <p>
                <strong>Patient No:</strong>
                {{ $appointment->patient->patient_number ?? 'N/A' }}
            </p>

            <p>
                <strong>Appointment Date:</strong>
                {{ $appointment->appointment_date->format('F j, Y') }}
            </p>

            <p>
                <strong>Appointment Time:</strong>
                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
            </p>

        </div>

    </div>


    <hr>


    {{-- Intake Form --}}
    <form
        class="intake-form"
        action="{{ route('staff.appointments.intake.store', $appointment) }}"
        method="POST"
    >

        @csrf


        {{-- Basic Measurements --}}
        <div class="intake-section">

            <h3>🩺 Basic Measurements</h3>

            <div class="form-grid">

                <div class="form-group">

                    <label for="height">
                        Height (cm)
                    </label>

                    <input
                        type="number"
                        id="height"
                        name="height"
                        value="{{ old('height', $appointment->patientIntake?->height) }}"
                        step="0.01"
                        min="1"
                        max="300"
                        placeholder="e.g. 170"
                    >

                </div>


                <div class="form-group">

                    <label for="weight">
                        Weight (kg)
                    </label>

                    <input
                        type="number"
                        id="weight"
                        name="weight"
                        value="{{ old('weight', $appointment->patientIntake?->weight) }}"
                        step="0.01"
                        min="1"
                        max="500"
                        placeholder="e.g. 65"
                    >

                </div>

            </div>

        </div>


        <hr>


        {{-- Medical History --}}
        <div class="intake-section">

            <h3>🏥 Medical History</h3>


            <div class="form-group">

                <label for="comorbidities">
                    Comorbidities / Existing Conditions
                </label>

                <textarea
                    id="comorbidities"
                    name="comorbidities"
                    rows="4"
                    placeholder="List any existing medical conditions..."
                >{{ old('comorbidities', $appointment->patientIntake?->comorbidities) }}</textarea>

            </div>


            <div class="form-group">

                <label for="maintenance_medications">
                    Maintenance Medications
                </label>

                <textarea
                    id="maintenance_medications"
                    name="maintenance_medications"
                    rows="4"
                    placeholder="List current maintenance medications..."
                >{{ old('maintenance_medications', $appointment->patientIntake?->maintenance_medications) }}</textarea>

            </div>


            <div class="form-group">

                <label for="allergies">
                    Allergies
                </label>

                <textarea
                    id="allergies"
                    name="allergies"
                    rows="4"
                    placeholder="List known allergies..."
                >{{ old('allergies', $appointment->patientIntake?->allergies) }}</textarea>

            </div>


            {{-- Diabetes --}}
            <div class="form-group">

                <label>
                    <input
                        type="hidden"
                        name="has_diabetes"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="has_diabetes"
                        value="1"
                        {{ old(
                            'has_diabetes',
                            $appointment->patientIntake?->has_diabetes
                        ) ? 'checked' : '' }}
                    >

                    Patient has diabetes

                </label>

            </div>


            {{-- Hypertension --}}
            <div class="form-group">

                <label>

                    <input
                        type="hidden"
                        name="has_hypertension"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="has_hypertension"
                        value="1"
                        {{ old(
                            'has_hypertension',
                            $appointment->patientIntake?->has_hypertension
                        ) ? 'checked' : '' }}
                    >

                    Patient has hypertension

                </label>

            </div>


            <div class="form-group">

                <label for="other_medical_information">
                    Other Medical Information
                </label>

                <textarea
                    id="other_medical_information"
                    name="other_medical_information"
                    rows="5"
                    placeholder="Enter any other relevant medical information..."
                >{{ old(
                    'other_medical_information',
                    $appointment->patientIntake?->other_medical_information
                ) }}</textarea>

            </div>

        </div>


        <hr>


        {{-- Actions --}}
        <div
            style="
                display: flex;
                gap: 12px;
                align-items: center;
            "
        >

            <a
                href="{{ route('staff.appointments.show', $appointment) }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                ✓ Complete Patient Intake
            </button>

        </div>

    </form>

</div>

@endsection