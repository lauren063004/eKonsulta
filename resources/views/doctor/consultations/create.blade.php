@extends('layouts.dashboard')

@section('title', 'Record Consultation')

@section('page-title', 'Record Consultation')

@section('content')

    <div class="dashboard-card clinical-workspace consultation-create-page">

        <div class="card-header">
            <div>
                <h3>Record Consultation</h3>
                <p>Enter the patient's consultation information</p>
            </div>

            <a href="{{ route('doctor.appointments.index') }}">
                Back to Appointments
            </a>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Please correct the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="consult-layout">

            {{-- Patient Information (left panel, per Figure 12) --}}
            <aside class="patient-panel" aria-label="Patient information">

                <div class="patient-panel-head">

                    <div class="appointment-date appointment-date--compact">
                        <strong>
                            {{ $appointment->appointment_date->format('M') }}
                        </strong>

                        <span class="appointment-date-day">
                            {{ $appointment->appointment_date->format('d') }}
                        </span>
                    </div>

                    <div>
                        <strong>
                            {{ $appointment->patient->user->name ?? 'Patient' }}
                        </strong>

                        @if($appointment->patient)
                            <small>
                                Patient No:
                                {{ $appointment->patient->patient_number }}
                            </small>
                        @endif
                    </div>

                </div>

                @if($appointment->healthCenter)
                    <div class="patient-fact">
                        <span>Health Center</span>
                        <strong>
                            {{ $appointment->healthCenter->name }}
                        </strong>
                    </div>
                @endif

                <div class="patient-fact">
                    <span>Appointment Time</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                    </strong>
                </div>

                @if($appointment->reason)
                    <div class="patient-fact">
                        <span>Reason for Visit</span>
                        <strong>
                            {{ $appointment->reason }}
                        </strong>
                    </div>
                @endif

                <span class="appointment-status status-{{ strtolower($appointment->status) }}">
                    {{ ucfirst($appointment->status) }}
                </span>

            </aside>

            <div class="consultation-main-column">

            {{-- Consultation Form --}}
            {{-- Staff Patient Intake --}}
            @if($appointment->patientIntake)
                <div class="dashboard-card patient-intake-card">
                    <div class="card-header">
                        <div>
                            <h3>Staff Patient Intake</h3>
                            <p>Pre-consultation information recorded by health center staff</p>
                        </div>
                    </div>

                    <div class="patient-intake-metrics">

                        <div class="patient-fact">
                            <span>Height</span>
                            <strong>
                                {{ $appointment->patientIntake->height !== null
                                    ? number_format((float) $appointment->patientIntake->height, 2) . ' cm'
                                    : 'Not recorded' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Weight</span>
                            <strong>
                                {{ $appointment->patientIntake->weight !== null
                                    ? number_format((float) $appointment->patientIntake->weight, 2) . ' kg'
                                    : 'Not recorded' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>BMI</span>
                            <strong>
                                @php
                                    $height = (float) $appointment->patientIntake->height;
                                    $weight = (float) $appointment->patientIntake->weight;
                                    $bmi = $height > 0 ? $weight / (($height / 100) ** 2) : null;
                                @endphp

                                {{ $bmi !== null ? number_format($bmi, 2) : 'Not available' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Diabetes</span>
                            <strong>
                                {{ $appointment->patientIntake->has_diabetes ? 'Yes' : 'No' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Hypertension</span>
                            <strong>
                                {{ $appointment->patientIntake->has_hypertension ? 'Yes' : 'No' }}
                            </strong>
                        </div>

                    </div>

                    <div class="patient-intake-notes">

                        <div class="patient-fact">
                            <span>Allergies</span>
                            <strong>
                                {{ $appointment->patientIntake->allergies ?: 'None reported' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Comorbidities</span>
                            <strong>
                                {{ $appointment->patientIntake->comorbidities ?: 'None reported' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Maintenance Medications</span>
                            <strong>
                                {{ $appointment->patientIntake->maintenance_medications ?: 'None reported' }}
                            </strong>
                        </div>

                        <div class="patient-fact">
                            <span>Other Medical Information</span>
                            <strong>
                                {{ $appointment->patientIntake->other_medical_information ?: 'None reported' }}
                            </strong>
                        </div>

                    </div>

                    @if($appointment->patientIntake->staff)
                        <div class="patient-intake-completed-by">
                            <small>
                                Intake completed by:
                                <strong>
                                    {{ $appointment->patientIntake->staff->user->name ?? 'Health Center Staff' }}
                                </strong>

                                @if($appointment->patientIntake->completed_at)
                                    on
                                    {{ $appointment->patientIntake->completed_at->format('M d, Y h:i A') }}
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
            @endif
            <form
                class="clinical-form"
                action="{{ route('doctor.appointments.consultation.store', $appointment) }}"
                method="POST"
            >

                @csrf

                <div class="form-section">

                    <div class="form-section-head">
                        <span class="step-number">1</span>
                        <div>
                            <h4>Complaint &amp; Symptoms</h4>
                            <p>What the patient reports</p>
                        </div>
                    </div>

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

                </div>


                <div class="form-section">

                    <div class="form-section-head">
                        <span class="step-number">2</span>
                        <div>
                            <h4>Diagnosis &amp; Treatment</h4>
                            <p>Findings and recommended plan</p>
                        </div>
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

                </div>


                <div class="form-actions">

                    <a
                        href="{{ route('doctor.appointments.index') }}"
                        class="secondary-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Save Consultation
                    </button>

                </div>

            </form>

            </div>
        </div>

    </div>

@endsection