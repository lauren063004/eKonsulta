@extends('layouts.dashboard')

@section('title', 'Health Center Details')

@section('page-title', 'Health Center Details')

@section('content')

<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>{{ $healthCenter->name }}</h3>
            <p>Health center information and resources</p>
        </div>

        <a href="{{ route('admin.health-centers.index') }}">
            Back to Health Centers
        </a>
    </div>

    <div class="appointment-details">

        <p>
            <strong>🏥 Name:</strong>
            {{ $healthCenter->name }}
        </p>

        <p>
            <strong>Address:</strong>
            {{ $healthCenter->address ?? 'Not provided' }}
        </p>

        <p>
            <strong>Contact:</strong>
            {{ $healthCenter->contact_number ?? 'Not provided' }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $healthCenter->email ?? 'Not provided' }}
        </p>

        <p>
            <strong>Operating Hours:</strong>
            {{ $healthCenter->operating_hours ?? 'Not provided' }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ ucfirst($healthCenter->status) }}
        </p>

    </div>

</section>


<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>👨‍⚕️ Doctors</h3>
            <p>Doctors assigned to this health center</p>
        </div>
    </div>

    @if($healthCenter->doctors->count())

        @foreach($healthCenter->doctors as $doctor)

            <div class="appointment-preview">

                <div class="appointment-details">

                    <h4>
                        Dr. {{ $doctor->user->name ?? 'Doctor' }}
                    </h4>

                    <p>
                        <strong>Specialization:</strong>
                        {{ $doctor->specialization ?? 'Not specified' }}
                    </p>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <div class="empty-state">
            <h4>No doctors assigned</h4>
            <p>No doctors are currently assigned to this health center.</p>
        </div>

    @endif

</section>


<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>👥 Staff</h3>
            <p>Staff members assigned to this health center</p>
        </div>
    </div>

    @if($healthCenter->staff->count())

        @foreach($healthCenter->staff as $staff)

            <div class="appointment-preview">

                <div class="appointment-details">

                    <h4>
                        {{ $staff->user->name ?? 'Staff Member' }}
                    </h4>

                    <p>
                        <strong>Role:</strong>
                        Staff
                    </p>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <div class="empty-state">
            <h4>No staff assigned</h4>
            <p>No staff members are currently assigned to this health center.</p>
        </div>

    @endif

</section>


<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>📅 Appointments</h3>
            <p>Appointments associated with this health center</p>
        </div>
    </div>

    @if($healthCenter->appointments->count())

        @foreach($healthCenter->appointments as $appointment)

            <div class="appointment-preview">

                <div class="appointment-details">

                    <h4>
                        {{ $appointment->patient->user->name ?? 'Patient' }}
                    </h4>

                    <p>
                        <strong>Doctor:</strong>
                        Dr. {{ $appointment->doctor->user->name ?? 'Not assigned' }}
                    </p>

                    <p>
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($appointment->status) }}
                    </p>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <div class="empty-state">
            <h4>No appointments</h4>
            <p>No appointments are currently associated with this health center.</p>
        </div>

    @endif

</section>


<section class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>💊 Medicines</h3>
            <p>Medicines available at this health center</p>
        </div>
    </div>

    @if($healthCenter->medicines->count())

        @foreach($healthCenter->medicines as $medicine)

            <div class="appointment-preview">

                <div class="appointment-details">

                    <h4>
                        {{ $medicine->name }}
                    </h4>

                    <p>
                        <strong>Generic Name:</strong>
                        {{ $medicine->generic_name ?? 'Not provided' }}
                    </p>

                    <p>
                        <strong>Strength:</strong>
                        {{ $medicine->strength ?? 'Not provided' }}
                    </p>

                    <p>
                        <strong>Dosage Form:</strong>
                        {{ $medicine->dosage_form ?? 'Not provided' }}
                    </p>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <div class="empty-state">
            <h4>No medicines</h4>
            <p>No medicines are currently recorded for this health center.</p>
        </div>

    @endif

</section>


<a href="{{ route('admin.health-centers.index') }}">
    ← Back to Health Centers
</a>

@endsection