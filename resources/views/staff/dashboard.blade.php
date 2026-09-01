@extends('layouts.dashboard')

@section('title', 'Staff Dashboard')

@section('page-title', 'Staff Dashboard')

@section('content')

    <section class="welcome-banner">

        <div>
            <span class="welcome-label">
                e-Konsulta Health Center Portal
            </span>

            <h1>
                Good day, {{ auth()->user()->name }}!
            </h1>

            <p>
                Manage residents, appointments, and
                health-center services.
            </p>
        </div>

        <div class="welcome-icon">
            🏥
        </div>

    </section>


   <section class="stats-grid">

    <x-stat-card
        icon="👥"
        label="Registered Patients"
        value="{{ $registeredPatients }}"
    />

    <x-stat-card
        icon="📅"
        label="Today's Appointments"
        value="{{ $todayAppointments }}"
    />

    <x-stat-card
        icon="🩺"
        label="Today's Consultations"
        value="{{ $todayConsultations }}"
    />

    <x-stat-card
        icon="⏳"
        label="Pending Requests"
        value="{{ $pendingRequests }}"
    />

</section>


    <div class="dashboard-grid">

        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Today's Appointments</h3>
                    <p>Appointments requiring attention</p>
                </div>

              <a href="{{ route('staff.appointments.index') }}">
    View All
</a>

            </div>

        @if($appointments->count())

    <div class="medical-records-list">

        @foreach($appointments as $appointment)

            <div class="appointment-preview">

                <div class="appointment-date">

                    <strong>
                        {{ $appointment->appointment_time->format('g:i') }}
                    </strong>

                    <span>
                        {{ $appointment->appointment_time->format('A') }}
                    </span>

                </div>

                <div class="appointment-details">

                    <h4>
                        {{ $appointment->patient->user->name ?? 'Patient' }}
                    </h4>

                    @if($appointment->patient)

                        <p>
                            <strong>Patient No:</strong>
                            {{ $appointment->patient->patient_number }}
                        </p>

                    @endif

                    @if($appointment->doctor && $appointment->doctor->user)

                        <p>
                            👨‍⚕️
                            {{ $appointment->doctor->user->name }}
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
                            <strong>Reason:</strong>
                            {{ $appointment->reason }}
                        </p>

                    @endif

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($appointment->status) }}
                    </p>

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

        <h4>No appointments today</h4>

        <p>
            There are no appointments scheduled for today.
        </p>

    </div>

@endif

        </section>


        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Staff Actions</h3>
                    <p>Common administrative tasks</p>
                </div>

            </div>

            <div class="quick-actions">

                <a href="{{ route('staff.patients.index') }}" class="quick-action">
    <span>👥</span>
    <strong>Patients</strong>
    <small>Register and manage residents</small>
</a>

               <a href="{{ route('staff.appointments.index') }}" class="quick-action">
    <span>📅</span>
    <strong>Appointments</strong>
    <small>Manage patient appointments</small>
</a>

             <a href="{{ route('staff.health-centers.index') }}" class="quick-action">
    <span>🏥</span>
    <strong>Health Center</strong>
    <small>View center information</small>
</a>
<a href="{{ route('staff.consultations.index') }}" class="quick-action">
    <span>🩺</span>
    <strong>Consultations</strong>
    <small>View consultation records</small>
</a>

            </div>

        </section>

    </div>

@endsection