@extends('layouts.dashboard')

@section('title', 'Patient Profile')

@section('page-title', 'Patient Profile')

@section('content')

<div class="dashboard-card">

    {{-- Header --}}
    <div class="card-header">
        <div>
            <h3>
                {{ $patient->user->name ?? 'Patient' }}
            </h3>

            <p>
                Clinical profile and medical history
            </p>
        </div>

        <a href="{{ route('doctor.patients.index') }}">
            Back to Patients
        </a>
    </div>


    {{-- Patient Information --}}
    <div class="appointment-preview">

        <div class="appointment-date">
            <strong>👤</strong>
        </div>

        <div class="appointment-details">

            <h4>
                {{ $patient->user->name ?? 'Patient' }}
            </h4>

            <p>
                <strong>Patient No:</strong>
                {{ $patient->patient_number }}
            </p>

            @if($patient->user)
                <p>
                    <strong>Email:</strong>
                    {{ $patient->user->email }}
                </p>
            @endif

        </div>

    </div>


    {{-- Appointments --}}
    <div style="margin-top: 30px;">

        <h3>📅 Appointments</h3>

        @if($patient->appointments->count())

            @foreach($patient->appointments as $appointment)

                <div class="dashboard-card" style="margin-top: 15px;">

                    <div class="card-header">

                        <div>
                            <strong>
                                {{ $appointment->appointment_date->format('M d, Y') }}
                            </strong>

                            <p>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </p>
                        </div>

                        <span class="appointment-status">
                            {{ ucfirst($appointment->status) }}
                        </span>

                    </div>

                    @if($appointment->reason)
                        <p>
                            <strong>Reason:</strong>
                            {{ $appointment->reason }}
                        </p>
                    @endif

                    @if($appointment->healthCenter)
                        <p>
                            🏥 {{ $appointment->healthCenter->name }}
                        </p>
                    @endif

                </div>

            @endforeach

        @else

            <p>No appointments found.</p>

        @endif

    </div>


    {{-- Consultations --}}
    <div style="margin-top: 30px;">

        <h3>🩺 Consultations</h3>

        @if($patient->consultations->count())

            @foreach($patient->consultations as $consultation)

                <div class="dashboard-card" style="margin-top: 15px;">

                    <div class="card-header">

                        <div>
                            <strong>
                                {{ $consultation->consultation_date
                                    ? \Carbon\Carbon::parse($consultation->consultation_date)->format('M d, Y g:i A')
                                    : 'Consultation'
                                }}
                            </strong>
                        </div>

                    </div>

                    <p>
                        <strong>Chief Complaint:</strong><br>
                        {{ $consultation->chief_complaint }}
                    </p>

                    @if($consultation->symptoms)
                        <p>
                            <strong>Symptoms:</strong><br>
                            {{ $consultation->symptoms }}
                        </p>
                    @endif

                    <p>
                        <strong>Diagnosis:</strong><br>
                        {{ $consultation->diagnosis }}
                    </p>

                    @if($consultation->treatment_plan)
                        <p>
                            <strong>Treatment Plan:</strong><br>
                            {{ $consultation->treatment_plan }}
                        </p>
                    @endif

                    @if($consultation->notes)
                        <p>
                            <strong>Notes:</strong><br>
                            {{ $consultation->notes }}
                        </p>
                    @endif

                </div>

            @endforeach

        @else

            <p>No consultations recorded yet.</p>

        @endif

    </div>


    {{-- Prescriptions --}}
    <div style="margin-top: 30px;">

        <h3>💊 Prescriptions</h3>

        @if($patient->prescriptions->count())

            @foreach($patient->prescriptions as $prescription)

                <div class="dashboard-card" style="margin-top: 15px;">

                    <div class="card-header">

                        <div>
                            <strong>
                                Prescription
                            </strong>

                            @if($prescription->created_at)
                                <p>
                                    {{ $prescription->created_at->format('M d, Y') }}
                                </p>
                            @endif
                        </div>

                    </div>

                    @if($prescription->items->count())

                        <ul>

                            @foreach($prescription->items as $item)

                                <li style="margin-bottom: 8px;">

                                    <strong>
                                        {{ $item->medicine_name ?? $item->name ?? 'Medicine' }}
                                    </strong>

                                    @if(!empty($item->dosage))
                                        — {{ $item->dosage }}
                                    @endif

                                    @if(!empty($item->frequency))
                                        — {{ $item->frequency }}
                                    @endif

                                    @if(!empty($item->duration))
                                        — {{ $item->duration }}
                                    @endif

                                </li>

                            @endforeach

                        </ul>

                    @else

                        <p>No prescription items recorded.</p>

                    @endif

                </div>

            @endforeach

        @else

            <p>No prescriptions recorded yet.</p>

        @endif

    </div>


    {{-- Back Button --}}
    <div style="margin-top: 30px;">

        <a
            href="{{ route('doctor.patients.index') }}"
            class="primary-button"
        >
            ← Back to Patients
        </a>

    </div>

</div>

@endsection