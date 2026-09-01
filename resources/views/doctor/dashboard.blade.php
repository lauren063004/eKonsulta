@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard')

@section('page-title', 'Doctor Dashboard')

@section('content')

    <section class="welcome-banner">

        <div>
            <span class="welcome-label">
                e-Konsulta Clinical Portal
            </span>

            <h1>
                Good day, Dr. {{ auth()->user()->name }}!
            </h1>

            <p>
                Manage your appointments, patients,
                consultations, and prescriptions.
            </p>
        </div>

        <div class="welcome-icon">
            🩺
        </div>

    </section>


    <section class="stats-grid">

      <x-stat-card
    icon="📅"
    label="Today's Appointments"
    :value="$todayAppointments->count()"
/>

<x-stat-card
    icon="👥"
    label="Patients"
    :value="$patientCount"
/>

<x-stat-card
    icon="🩺"
    label="Consultations"
    :value="$consultationCount"
/>

<x-stat-card
    icon="💊"
    label="Prescriptions"
    :value="$prescriptionCount"
/>

    </section>


    <div class="dashboard-grid">

        <section class="dashboard-card">

            <div class="card-header">

@if($todayAppointments->count())

    <div class="appointments-list">

        @foreach($todayAppointments as $appointment)

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

                    <span class="appointment-status">
                        {{ ucfirst($appointment->status) }}
                    </span>

                </div>

            </div>

        @endforeach

    </div>

@else

 @if($todayAppointments->count())

    <div class="appointments-list">

        @foreach($todayAppointments as $appointment)

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

                    <span class="appointment-status">
                        {{ ucfirst($appointment->status) }}
                    </span>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="empty-state">

        <div class="empty-icon">
            📅
        </div>

        <h4>No appointments today</h4>

        <p>
            You currently have no appointments scheduled for today.
        </p>

        <a
            href="{{ route('doctor.appointments.index') }}"
            class="primary-button"
        >
            View All Appointments
        </a>

    </div>

@endif

@endif

               <a href="{{ route('doctor.appointments.index') }}">
    View All
</a>

            </div>

            <div class="empty-state">

                <div class="empty-icon">
                    📅
                </div>

                <h4>No appointments today</h4>

                <p>
                    Your appointment schedule is currently empty.
                </p>

            </div>

        </section>


        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Quick Actions</h3>
                    <p>Clinical tools</p>
                </div>

            </div>

           <div class="quick-actions">

    <a href="{{ route('doctor.appointments.index') }}" class="quick-action">
        <span>📅</span>
        <strong>Appointments</strong>
        <small>Manage your schedule</small>
    </a>

    <a href="{{ route('doctor.consultations.index') }}" class="quick-action">
        <span>🩺</span>
        <strong>Consultations</strong>
        <small>View consultation records</small>
    </a>

    <a href="{{ route('doctor.prescriptions.index') }}" class="quick-action">
        <span>💊</span>
        <strong>Prescriptions</strong>
        <small>Manage prescriptions</small>
    </a>

    <a href="{{ route('doctor.patients.index') }}" class="quick-action">
        <span>👥</span>
        <strong>Patients</strong>
        <small>View your patients</small>
    </a>

</div>
        </section>

    </div>

@endsection