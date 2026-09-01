@extends('layouts.dashboard')

@section('title', 'Patients')

@section('page-title', 'Patients')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Registered Patients</h3>
            <p>Manage patients registered in the health center</p>
        </div>

        <a href="{{ route('staff.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($patients->count())

        <div class="medical-records-list">

            @foreach($patients as $patient)

                <div class="appointment-preview">

                    <div class="appointment-date">
                        <strong>👤</strong>
                    </div>

                    <div class="appointment-details">

                        <h4>
                            {{ $patient->user->name ?? 'Patient' }}
                        </h4>

                        @if($patient->patient_number)
                            <p>
                                <strong>Patient No:</strong>
                                {{ $patient->patient_number }}
                            </p>
                        @endif

                        @if($patient->user && $patient->user->email)
                            <p>
                                <strong>Email:</strong>
                                {{ $patient->user->email }}
                            </p>
                        @endif

                        @if($patient->contact_number)
                            <p>
                                <strong>Contact:</strong>
                                {{ $patient->contact_number }}
                            </p>
                        @endif

                        <div style="margin-top: 15px;">
                            <a
                                href="{{ route('staff.patients.show', $patient) }}"
                                class="primary-button"
                            >
                                View Patient
                            </a>
                        </div>

                    </div>

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                👥
            </div>

            <h4>No registered patients</h4>

            <p>
                Patients registered in the system will appear here.
            </p>

        </div>

    @endif

</div>

@endsection