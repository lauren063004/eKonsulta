@extends('layouts.dashboard')

@section('title', 'Health Center Details')

@section('page-title', 'Health Center Details')

@section('content')

<div class="health-center-details-page">

    {{-- HEALTH CENTER PROFILE --}}

    <div class="dashboard-card health-center-profile-card">

        <div class="health-center-profile-header">

            <div class="health-center-avatar">
                &#127973;
            </div>

            <div class="health-center-profile-name">

                <span class="profile-label">
                    HEALTH CENTER
                </span>

                <h2>
                    {{ $healthCenter->name }}
                </h2>

                @if($healthCenter->address)
                    <p>
                        {{ $healthCenter->address }}
                    </p>
                @endif

            </div>

            <div class="health-center-profile-action">

                <span class="status-badge {{ $healthCenter->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ ucfirst($healthCenter->status) }}
                </span>

            </div>

        </div>


        <div class="health-center-information-grid">

            @if($healthCenter->contact_number)
                <div class="health-center-info-item">
                    <span>CONTACT</span>
                    <strong>{{ $healthCenter->contact_number }}</strong>
                </div>
            @endif

            @if($healthCenter->email)
                <div class="health-center-info-item">
                    <span>EMAIL</span>
                    <strong>{{ $healthCenter->email }}</strong>
                </div>
            @endif

            @if($healthCenter->operating_hours)
                <div class="health-center-info-item">
                    <span>OPERATING HOURS</span>
                    <strong>{{ $healthCenter->operating_hours }}</strong>
                </div>
            @endif

            <div class="health-center-info-item">
                <span>DOCTORS</span>
                <strong>{{ $healthCenter->doctors->count() }}</strong>
            </div>

            <div class="health-center-info-item">
                <span>STAFF</span>
                <strong>{{ $healthCenter->staff->count() }}</strong>
            </div>

        </div>

    </div>


    {{-- DOCTORS --}}

    <div class="dashboard-card health-center-section-card">

        <div class="section-title">

            <div class="section-icon">
                &#128104;
            </div>

            <div>
                <h3>Doctors</h3>
                <p>Doctors assigned to this health center</p>
            </div>

        </div>


        @if($healthCenter->doctors->count())

            <div class="health-center-resource-list">

                @foreach($healthCenter->doctors as $doctor)

                    <div class="health-center-resource-card">

                        <div class="resource-avatar">
                            &#128100;
                        </div>

                        <div class="resource-information">

                            <h4>
                                {{ $doctor->user->name ?? 'Doctor' }}
                            </h4>

                            @if($doctor->specialization)
                                <p>
                                    {{ $doctor->specialization }}
                                </p>
                            @else
                                <p>
                                    Medical Doctor
                                </p>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="health-center-empty-state">

                <div class="empty-icon">
                    &#128104;
                </div>

                <h4>No doctors assigned</h4>

                <p>
                    No doctors are currently assigned to this health center.
                </p>

            </div>

        @endif

    </div>


    {{-- STAFF --}}

    <div class="dashboard-card health-center-section-card">

        <div class="section-title">

            <div class="section-icon">
                &#128101;
            </div>

            <div>
                <h3>Staff</h3>
                <p>Staff members assigned to this health center</p>
            </div>

        </div>


        @if($healthCenter->staff->count())

            <div class="health-center-resource-list">

                @foreach($healthCenter->staff as $staff)

                    <div class="health-center-resource-card">

                        <div class="resource-avatar">
                            &#128100;
                        </div>

                        <div class="resource-information">

                            <h4>
                                {{ $staff->user->name ?? 'Staff Member' }}
                            </h4>

                            <p>
                                Health Center Staff
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="health-center-empty-state">

                <div class="empty-icon">
                    &#128101;
                </div>

                <h4>No staff assigned</h4>

                <p>
                    No staff members are currently assigned to this health center.
                </p>

            </div>

        @endif

    </div>


    {{-- APPOINTMENTS --}}

    <div class="dashboard-card health-center-section-card">

        <div class="section-title">

            <div class="section-icon">
                &#128197;
            </div>

            <div>
                <h3>Appointments</h3>
                <p>Appointments recorded for this health center</p>
            </div>

        </div>


        @if($healthCenter->appointments->count())

            <div class="health-center-appointment-list">

                @foreach($healthCenter->appointments as $appointment)

                    <div class="health-center-appointment-card">

                        <div class="appointment-patient">

                            <div class="resource-avatar">
                                &#128100;
                            </div>

                            <div>
                                <span class="profile-label">
                                    PATIENT
                                </span>

                                <h4>
                                    {{ $appointment->patient->user->name ?? 'Patient' }}
                                </h4>
                            </div>

                        </div>


                        <div class="appointment-information">

                            @if($appointment->doctor && $appointment->doctor->user)
                                <div>
                                    <span>DOCTOR</span>
                                    <strong>
                                        {{ $appointment->doctor->user->name }}
                                    </strong>
                                </div>
                            @endif

                            <div>
                                <span>DATE</span>
                                <strong>
                                    {{ $appointment->appointment_date->format('F j, Y') }}
                                </strong>
                            </div>

                            <div>
                                <span>TIME</span>
                                <strong>
                                    {{ $appointment->appointment_time->format('g:i A') }}
                                </strong>
                            </div>

                            <div>
                                <span>STATUS</span>
                                <strong>
                                    <span class="status-badge appointment-status">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </strong>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="health-center-empty-state">

                <div class="empty-icon">
                    &#128197;
                </div>

                <h4>No appointments recorded</h4>

                <p>
                    No appointments are currently recorded for this health center.
                </p>

            </div>

        @endif

    </div>


    {{-- MEDICINES --}}

    <div class="dashboard-card health-center-section-card">

        <div class="section-title">

            <div class="section-icon">
                &#128138;
            </div>

            <div>
                <h3>Medicines</h3>
                <p>Medicines available at this health center</p>
            </div>

        </div>


        @if($healthCenter->medicines->count())

            <div class="health-center-medicine-list">

                @foreach($healthCenter->medicines as $medicine)

                    <div class="health-center-medicine-card">

                        <div class="medicine-icon">
                            &#128138;
                        </div>

                        <div class="medicine-information">

                            <h4>
                                {{ $medicine->name }}
                            </h4>

                            @if($medicine->generic_name)
                                <p>
                                    {{ $medicine->generic_name }}
                                </p>
                            @endif

                        </div>

                        <div class="medicine-details">

                            @if($medicine->strength)
                                <div>
                                    <span>STRENGTH</span>
                                    <strong>
                                        {{ $medicine->strength }}
                                    </strong>
                                </div>
                            @endif

                            @if($medicine->dosage_form)
                                <div>
                                    <span>DOSAGE FORM</span>
                                    <strong>
                                        {{ $medicine->dosage_form }}
                                    </strong>
                                </div>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="health-center-empty-state">

                <div class="empty-icon">
                    &#128138;
                </div>

                <h4>No medicines recorded</h4>

                <p>
                    No medicines are currently recorded for this health center.
                </p>

            </div>

        @endif

    </div>


    {{-- BACK BUTTON --}}

    <div class="health-center-back-action">

        <a
            href="{{ route('staff.health-centers.index') }}"
            class="primary-button"
        >
            Back to Health Centers
        </a>

    </div>

</div>

@endsection