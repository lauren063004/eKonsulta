@extends('layouts.dashboard')

@section('title', 'Health Center Details')

@section('page-title', 'Health Center Details')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Health Center Details</h3>
            <p>Health center information and resources</p>
        </div>

        <a href="{{ route('staff.health-centers.index') }}">
            Back to Health Centers
        </a>

    </div>


    {{-- HEALTH CENTER INFORMATION --}}

    <div class="appointment-preview">

        <div class="appointment-date">

            <strong>🏥</strong>

            <span>
                {{ strtoupper(substr($healthCenter->name, 0, 1)) }}
            </span>

        </div>

        <div class="appointment-details">

            <h4>
                {{ $healthCenter->name }}
            </h4>

            @if($healthCenter->address)
                <p>
                    <strong>Address:</strong>
                    {{ $healthCenter->address }}
                </p>
            @endif

            @if($healthCenter->contact_number)
                <p>
                    <strong>Contact:</strong>
                    {{ $healthCenter->contact_number }}
                </p>
            @endif

            @if($healthCenter->email)
                <p>
                    <strong>Email:</strong>
                    {{ $healthCenter->email }}
                </p>
            @endif

            @if($healthCenter->operating_hours)
                <p>
                    <strong>Operating Hours:</strong>
                    {{ $healthCenter->operating_hours }}
                </p>
            @endif

            <p>
                <strong>Status:</strong>
                {{ ucfirst($healthCenter->status) }}
            </p>

        </div>

    </div>


    {{-- DOCTORS --}}

    <hr>

    <h3>👨‍⚕️ Doctors</h3>

    @if($healthCenter->doctors->count())

        <div class="medical-records-list">

            @foreach($healthCenter->doctors as $doctor)

                <div class="appointment-details">

                    <h4>
                      {{ $doctor->user->name ?? 'Doctor' }}
                    </h4>

                    @if($doctor->specialization)
                        <p>
                            <strong>Specialization:</strong>
                            {{ $doctor->specialization }}
                        </p>
                    @endif

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <p>No doctors are currently assigned to this health center.</p>

    @endif


    {{-- STAFF --}}

    <hr>

    <h3>👥 Staff</h3>

    @if($healthCenter->staff->count())

        <div class="medical-records-list">

            @foreach($healthCenter->staff as $staff)

                <div class="appointment-details">

                    <h4>
                        {{ $staff->user->name ?? 'Staff Member' }}
                    </h4>

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <p>No staff members are currently assigned to this health center.</p>

    @endif


    {{-- APPOINTMENTS --}}

    <hr>

    <h3>📅 Appointments</h3>

    @if($healthCenter->appointments->count())

        <div class="medical-records-list">

            @foreach($healthCenter->appointments as $appointment)

                <div class="appointment-details">

                    <h4>
                        {{ $appointment->patient->user->name ?? 'Patient' }}
                    </h4>

                    @if($appointment->doctor && $appointment->doctor->user)
                        <p>
                            <strong>Doctor:</strong>
                            {{ $appointment->doctor->user->name }}
                        </p>
                    @endif

                    <p>
                        <strong>Date:</strong>
                        {{ $appointment->appointment_date->format('F j, Y') }}
                    </p>

                    <p>
                        <strong>Time:</strong>
                        {{ $appointment->appointment_time->format('g:i A') }}
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($appointment->status) }}
                    </p>

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <p>No appointments are currently recorded for this health center.</p>

    @endif


    {{-- MEDICINES --}}

    <hr>

    <h3>💊 Medicines</h3>

    @if($healthCenter->medicines->count())

        <div class="medical-records-list">

            @foreach($healthCenter->medicines as $medicine)

                <div class="appointment-details">

                    <h4>
                        {{ $medicine->name }}
                    </h4>

                    @if($medicine->generic_name)
                        <p>
                            <strong>Generic Name:</strong>
                            {{ $medicine->generic_name }}
                        </p>
                    @endif

                    @if($medicine->strength)
                        <p>
                            <strong>Strength:</strong>
                            {{ $medicine->strength }}
                        </p>
                    @endif

                    @if($medicine->dosage_form)
                        <p>
                            <strong>Dosage Form:</strong>
                            {{ $medicine->dosage_form }}
                        </p>
                    @endif

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <p>No medicines are currently recorded for this health center.</p>

    @endif


    <div style="margin-top: 20px;">

        <a
            href="{{ route('staff.health-centers.index') }}"
            class="primary-button"
        >
            Back to Health Centers
        </a>

    </div>

</div>

@endsection