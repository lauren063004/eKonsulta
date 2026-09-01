@extends('layouts.dashboard')

@section('title', 'My Patients')

@section('page-title', 'My Patients')

@section('content')

    <div class="dashboard-card">

        <div class="card-header">

            <div>
                <h3>My Patients</h3>
                <p>Patients who have appointments with you</p>
            </div>

            <a href="{{ route('doctor.dashboard') }}">
                Back to Dashboard
            </a>

        </div>


        @if($patients->count())

            <div class="medical-records-list">

                @foreach($patients as $patient)

                    <div class="appointment-preview">

                        <div class="appointment-date">

                            <strong>
                                👤
                            </strong>

                        </div>


                     <div class="appointment-details">

    <h4>
        <a href="{{ route('doctor.patients.show', $patient) }}">
            {{ $patient->user->name ?? 'Patient' }}
        </a>
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


                            @if($patient->user && $patient->user->phone)

                                <p>
                                    <strong>Phone:</strong>
                                    {{ $patient->user->phone }}
                                </p>

                            @endif

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

                <h4>No patients yet</h4>

                <p>
                    Patients who have appointments with you
                    will appear here.
                </p>

            </div>

        @endif

    </div>

@endsection