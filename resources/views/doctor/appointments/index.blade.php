@extends('layouts.dashboard')

@section('title', 'Doctor Appointments')

@section('page-title', 'Appointments')

@section('content')

    <div class="dashboard-card">

        <div class="card-header">
            <div>
                <h3>Patient Appointments</h3>
                <p>Manage appointments assigned to you</p>
            </div>

            <a href="{{ route('doctor.dashboard') }}">
                Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($appointments->count())

            <div class="appointments-list">

                @foreach($appointments as $appointment)

                @if($appointment->status === 'pending')
    <form
        action="{{ route('doctor.appointments.approve', $appointment) }}"
        method="POST"
        style="display: inline;"
    >
        @csrf
        @method('PATCH')

        <button type="submit" class="primary-button">
            Approve Appointment
        </button>
    </form>
@endif

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
                                {{ $appointment->appointment_date->format('l, F j, Y') }}
                            </h4>

                            <p>
                                🕐
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </p>

                            @if($appointment->patient && $appointment->patient->user)

                                <p>
                                    👤
                                    {{ $appointment->patient->user->name }}
                                </p>

                            @endif

                            @if($appointment->patient)

                                <p>
                                    Patient No:
                                    {{ $appointment->patient->patient_number }}
                                </p>

                            @endif

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

@if($appointment->status === 'completed')
    <a
        href="{{ route('doctor.appointments.prescription.create', $appointment) }}"
        class="primary-button"
        style="display: inline-block; margin-top: 15px;"
    >
        💊 Create Prescription
    </a>
@endif

@if($appointment->status === 'pending')
    <form
        action="{{ route('doctor.appointments.approve', $appointment) }}"
        method="POST"
        style="margin-top: 15px;"
    >
        @csrf
        @method('PATCH')

        <button type="submit" class="primary-button">
            Approve Appointment
        </button>
    </form>
@endif

@if($appointment->status === 'approved')
    <a
        href="{{ route('doctor.appointments.consultation.create', $appointment) }}"
        class="primary-button"
        style="display: inline-block; margin-top: 15px;"
    >
        Start Consultation
    </a>
@endif

                        </div>

                    </div>

                    <hr>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📅
                </div>

                <h4>No appointments</h4>

                <p>
                    You currently have no appointments assigned to you.
                </p>

            </div>

        @endif

    </div>

@endsection