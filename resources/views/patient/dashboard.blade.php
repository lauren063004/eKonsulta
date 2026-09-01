@extends('layouts.dashboard')

@section('title', 'Patient Dashboard')

@section('page-title', 'Patient Dashboard')

@section('content')

    {{-- Welcome --}}
    <section class="welcome-banner">

        <div>
            <span class="welcome-label">
                e-Konsulta Patient Portal
            </span>

            <h1>
                Good day, {{ auth()->user()->name }}!
            </h1>

            <p>
                Manage your appointments, consultations,
                prescriptions, and health records in one place.
            </p>
        </div>

        <div class="welcome-icon">
            🩺
        </div>

    </section>


    {{-- Statistics --}}
    <section class="stats-grid">

        <x-stat-card
            icon="📅"
            label="Upcoming Appointments"
            :value="$upcomingAppointments->count()"
            description="Scheduled visits"
        />

        <x-stat-card
            icon="🩺"
            label="Consultations"
            :value="$consultationCount"
            description="Total consultations"
        />

        <x-stat-card
            icon="💊"
            label="Prescriptions"
            :value="$prescriptionCount"
            description="Total prescriptions"
        />

        <x-stat-card
            icon="🔔"
            label="Notifications"
            :value="$notificationCount"
            description="Unread notifications"
        />

    </section>


    {{-- Main Grid --}}
    <div class="dashboard-grid">

        {{-- Upcoming Appointment --}}
        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Upcoming Appointment</h3>
                    <p>Your next scheduled visit</p>
                </div>

             <a href="{{ route('patient.appointments.index') }}">
    View All
</a>

            </div>


            @if($nextAppointment)

                <div class="appointment-preview">

                    <div class="appointment-date">

                        <strong>
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M') }}
                        </strong>

                        <span>
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d') }}
                        </span>

                    </div>


                    <div class="appointment-details">

                        <h4>
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('l, F j, Y') }}
                        </h4>

                        <p>
                            🕐
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}
                        </p>


                        @if($nextAppointment->doctor && $nextAppointment->doctor->user)

                            <p>
                                👨‍⚕️
                                {{ $nextAppointment->doctor->user->name }}
                            </p>

                            @if($nextAppointment->doctor->specialization)

                                <p>
                                    🩺
                                    {{ $nextAppointment->doctor->specialization }}
                                </p>

                            @endif

                        @endif


                        @if($nextAppointment->healthCenter)

                            <p>
                                🏥
                                {{ $nextAppointment->healthCenter->name }}
                            </p>

                        @endif


                        @if($nextAppointment->reason)

                            <p>
                                Reason: {{ $nextAppointment->reason }}
                            </p>

                        @endif


                        <span class="appointment-status">
                            {{ ucfirst($nextAppointment->status) }}
                        </span>

                    </div>

                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        📅
                    </div>

                    <h4>No upcoming appointments</h4>

                    <p>
                        You currently don't have a scheduled appointment.
                    </p>

                  <a
    href="{{ route('patient.appointments.create') }}"
    class="primary-button"
>
    Book an Appointment
</a>

                </div>

            @endif

        </section>


        {{-- Quick Actions --}}
        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Quick Actions</h3>
                    <p>Common patient services</p>
                </div>

            </div>


            <div class="quick-actions">

               <a
    href="{{ route('patient.appointments.create') }}"
    class="quick-action"
>

                    <span>📅</span>

                    <strong>
                        Book Appointment
                    </strong>

                    <small>
                        Schedule a consultation
                    </small>

                </a>


               <a href="{{ route('patient.medical-records.index') }}" class="quick-action">
    <span>📋</span>
    <strong>Medical Records</strong>
    <small>View your health history</small>
</a>

                   <span>📋</span>

<strong>
    Medical Records
</strong>

<small>
    View your health history
</small>

</a>

               <a href="{{ route('patient.prescriptions.index') }}" class="quick-action">

                    <span>💊</span>

                    <strong>
                        Prescriptions
                    </strong>

                    <small>
                        View prescribed medicines
                    </small>

                </a>


               <a href="{{ route('patient.profile') }}" class="quick-action">

    <span>👤</span>

    <strong>
        My Profile
    </strong>

    <small>
        Update your information
    </small>

</a>

            </div>

        </section>

    </div>


    {{-- Health Reminder --}}
    <section class="dashboard-card health-reminder">

        <div class="reminder-icon">
            ❤️
        </div>

        <div>

            <h3>
                Stay on top of your health
            </h3>

            <p>
                Keep your personal information and emergency
                contact details updated to help our health staff
                provide better service.
            </p>

        </div>

    </section>

@endsection