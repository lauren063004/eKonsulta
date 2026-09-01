@extends('layouts.dashboard')

@section('title', 'Appointments')

@section('page-title', 'Appointments')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>All Appointments</h3>
            <p>Manage and monitor patient appointments</p>
        </div>

        <a href="{{ route('staff.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($appointments->count())

        <div class="medical-records-list">

            @foreach($appointments as $appointment)

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
                                <strong>Doctor:</strong>
                              {{ $appointment->doctor->user->name }}
                            </p>

                        @endif

                        @if($appointment->healthCenter)

                            <p>
                                <strong>Health Center:</strong>
                                🏥 {{ $appointment->healthCenter->name }}
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

                        @if($appointment->reason)

                            <p>
                                <strong>Reason:</strong>
                                {{ $appointment->reason }}
                            </p>

                        @endif


                        {{-- ACTIONS --}}

                        <div style="margin-top: 15px;">

                            <a
                                href="{{ route('staff.appointments.show', $appointment) }}"
                                class="primary-button"
                            >
                                View Details
                            </a>


                            {{-- APPROVE / CANCEL --}}

                            @if($appointment->status === 'pending')

                                <div style="margin-top: 10px;">

                                    <form
                                        action="{{ route('staff.appointments.approve', $appointment) }}"
                                        method="POST"
                                        style="display: inline;"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="primary-button"
                                        >
                                            Approve
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route('staff.appointments.cancel', $appointment) }}"
                                        method="POST"
                                        style="display: inline;"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="primary-button"
                                        >
                                            Cancel
                                        </button>

                                    </form>

                                </div>

                            @endif

                        </div>

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

            <h4>No appointments yet</h4>

            <p>
                Patient appointments will appear here.
            </p>

        </div>

    @endif

</div>

@endsection