@extends('layouts.dashboard')

@section('title', 'Appointment Details')

@section('page-title', 'Appointment Details')

@section('content')

<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>Appointment Details</h3>
            <p>Review the patient's scheduled appointment.</p>
        </div>

        <a href="{{ route('doctor.dashboard') }}">
            Back to Dashboard
        </a>
    </div>

    <div class="appointment-preview">

        <div class="appointment-date">

            <strong>
                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}
            </strong>

            <span>
                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}
            </span>

        </div>

        <div class="appointment-details">

            <h4>
                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}
            </h4>

            <p>
                🕐
                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
            </p>

            <p>
                🏥
                {{ $appointment->healthCenter->name ?? 'Health center not available' }}
            </p>

            <p>
                📍
                {{ $appointment->healthCenter->address ?? 'Address not available' }}
            </p>

            <span class="appointment-status">
                {{ ucfirst($appointment->status) }}
            </span>

        </div>

    </div>

</section>


<section class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Patient Information</h3>
            <p>Patient details for this appointment.</p>
        </div>

    </div>

    <div class="patient-details">

        <p>
            <strong>Name:</strong>
            {{ $appointment->patient->user->name ?? 'N/A' }}
        </p>

        <p>
            <strong>Patient Number:</strong>
            {{ $appointment->patient->patient_number ?? 'N/A' }}
        </p>

        <p>
            <strong>Date of Birth:</strong>
            {{ $appointment->patient->date_of_birth
                ? \Carbon\Carbon::parse($appointment->patient->date_of_birth)->format('F j, Y')
                : 'N/A' }}
        </p>

        <p>
            <strong>Sex:</strong>
            {{ $appointment->patient->sex ?? 'N/A' }}
        </p>

        <p>
            <strong>Contact Number:</strong>
            {{ $appointment->patient->contact_number ?? 'N/A' }}
        </p>

        <p>
            <strong>Address:</strong>
            {{ $appointment->patient->address ?? 'N/A' }}
        </p>

    </div>

</section>


<section class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Appointment Reason</h3>
            <p>Information provided by the patient.</p>
        </div>

    </div>

    <div>

        <p>
            {{ $appointment->reason }}
        </p>

        @if($appointment->notes)

            <hr>

            <p>
                <strong>Additional Notes:</strong>
            </p>

            <p>
                {{ $appointment->notes }}
            </p>

        @endif

    </div>

</section>


@if($appointment->status === 'pending')

<section class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Doctor Action</h3>
            <p>Continue with this patient's consultation.</p>
        </div>

    </div>

    <a href="#" class="primary-button">
        🩺 Start Consultation
    </a>

</section>

@endif

@endsection