@extends('layouts.dashboard')

@section('title', 'Health Center Details')

@section('page-title', 'Health Center Details')

@section('content')

<div class="admin-health-center-details-page">

    {{-- HEALTH CENTER PROFILE --}}

    <section class="dashboard-card admin-health-center-profile-card">

        <div class="admin-health-center-profile-header">

            <div class="admin-health-center-profile-icon">
                &#127973;
            </div>

            <div class="admin-health-center-profile-information">

                <span class="admin-health-center-profile-label">
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

            <div class="admin-health-center-profile-status">

                <span class="status-badge {{ $healthCenter->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ ucfirst($healthCenter->status) }}
                </span>

            </div>

        </div>

        <div class="admin-health-center-summary">

            <div>
                <span>CONTACT</span>
                <strong>
                    {{ $healthCenter->contact_number ?? 'Not available' }}
                </strong>
            </div>

            <div>
                <span>EMAIL</span>
                <strong>
                    {{ $healthCenter->email ?? 'Not available' }}
                </strong>
            </div>

            <div>
                <span>OPERATING HOURS</span>
                <strong>
                    {{ $healthCenter->operating_hours ?? 'Not available' }}
                </strong>
            </div>

            <div>
                <span>DOCTORS</span>
                <strong>
                    {{ $healthCenter->doctors->count() }}
                </strong>
            </div>

            <div>
                <span>STAFF</span>
                <strong>
                    {{ $healthCenter->staff->count() }}
                </strong>
            </div>

        </div>

    </section>


    {{-- DOCTORS --}}

    <section class="dashboard-card admin-health-center-section-card">

        <div class="admin-health-center-section-heading">

            <div class="admin-health-center-section-icon">
                &#129658;
            </div>

            <div>
                <span>MEDICAL STAFF</span>
                <h3>Doctors</h3>
                <p>Doctors assigned to this health center</p>
            </div>

        </div>

        @if($healthCenter->doctors->count())

            <div class="admin-health-center-resource-list">

                @foreach($healthCenter->doctors as $doctor)

                    <div class="admin-health-center-resource-card">

                        <div class="admin-health-center-resource-avatar">
                            &#128100;
                        </div>

                        <div class="admin-health-center-resource-information">

                            <h4>
                                {{ $doctor->user->name ?? 'Doctor' }}
                            </h4>

                            <p>
                                {{ $doctor->specialization ?? 'Medical Doctor' }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="admin-health-center-empty-state">

                <div>
                    &#129658;
                </div>

                <h4>No doctors assigned</h4>

                <p>
                    No doctors are currently assigned to this health center.
                </p>

            </div>

        @endif

    </section>


    {{-- STAFF --}}

    <section class="dashboard-card admin-health-center-section-card">

        <div class="admin-health-center-section-heading">

            <div class="admin-health-center-section-icon">
                &#128101;
            </div>

            <div>
                <span>ADMINISTRATIVE STAFF</span>
                <h3>Staff</h3>
                <p>Staff members assigned to this health center</p>
            </div>

        </div>

        @if($healthCenter->staff->count())

            <div class="admin-health-center-resource-list">

                @foreach($healthCenter->staff as $staff)

                    <div class="admin-health-center-resource-card">

                        <div class="admin-health-center-resource-avatar">
                            &#128100;
                        </div>

                        <div class="admin-health-center-resource-information">

                            <h4>
                                {{ $staff->user->name ?? 'Staff Member' }}
                            </h4>

                            <p>
                                {{ $staff->position ?? 'Health Center Staff' }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="admin-health-center-empty-state">

                <div>
                    &#128101;
                </div>

                <h4>No staff assigned</h4>

                <p>
                    No staff members are currently assigned to this health center.
                </p>

            </div>

        @endif

    </section>


    {{-- APPOINTMENTS --}}

    <section class="dashboard-card admin-health-center-section-card">

        <div class="admin-health-center-section-heading">

            <div class="admin-health-center-section-icon">
                &#128197;
            </div>

            <div>
                <span>HEALTH CENTER ACTIVITY</span>
                <h3>Appointments</h3>
                <p>Appointments recorded for this health center</p>
            </div>

        </div>

        @if($healthCenter->appointments->count())

            <div class="admin-health-center-appointment-list">

                @foreach($healthCenter->appointments as $appointment)

                    <div class="admin-health-center-appointment-card">

                        <div class="admin-health-center-appointment-patient">

                            <div class="admin-health-center-resource-avatar">
                                &#128100;
                            </div>

                            <div>
                                <span>PATIENT</span>

                                <h4>
                                    {{ $appointment->patient->user->name ?? 'Patient' }}
                                </h4>

                            </div>

                        </div>

                        <div class="admin-health-center-appointment-information">

                            <div>
                                <span>DOCTOR</span>

                                <strong>
                                    {{ $appointment->doctor->user->name ?? 'Not assigned' }}
                                </strong>
                            </div>

                            <div>
                                <span>DATE</span>

                                <strong>
                                    {{ $appointment->appointment_date->format('F j, Y') }}
                                </strong>
                            </div>

                            <div>
                                <span>TIME</span>

                                <strong>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </strong>
                            </div>

                            <div>
                                <span>STATUS</span>

                                <strong>
                                    <span class="status-badge">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </strong>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="admin-health-center-empty-state">

                <div>
                    &#128197;
                </div>

                <h4>No appointments recorded</h4>

                <p>
                    No appointments are currently recorded for this health center.
                </p>

            </div>

        @endif

    </section>


    {{-- MEDICINES --}}

    <section class="dashboard-card admin-health-center-section-card">

        <div class="admin-health-center-section-heading">

            <div class="admin-health-center-section-icon">
                &#128138;
            </div>

            <div>
                <span>MEDICINE INVENTORY</span>
                <h3>Medicines</h3>
                <p>Medicines available at this health center</p>
            </div>

        </div>

        @if($healthCenter->medicines->count())

            <div class="admin-health-center-medicine-list">

                @foreach($healthCenter->medicines as $medicine)

                    <div class="admin-health-center-medicine-card">

                        <div class="admin-health-center-medicine-icon">
                            &#128138;
                        </div>

                        <div class="admin-health-center-medicine-information">

                            <h4>
                                {{ $medicine->name }}
                            </h4>

                            @if($medicine->generic_name)
                                <p>
                                    {{ $medicine->generic_name }}
                                </p>
                            @endif

                        </div>

                        <div class="admin-health-center-medicine-details">

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

            <div class="admin-health-center-empty-state">

                <div>
                    &#128138;
                </div>

                <h4>No medicines recorded</h4>

                <p>
                    No medicines are currently recorded for this health center.
                </p>

            </div>

        @endif

    </section>


    {{-- BACK BUTTON --}}

    <div class="admin-health-center-footer">

        <a
            href="{{ route('admin.health-centers.index') }}"
            class="primary-button"
        >
            Back to Health Centers
        </a>

    </div>

</div>

@endsection