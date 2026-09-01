@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('page-title', 'My Appointments')

@section('content')

    {{-- Flash Messages --}}

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- Page Header --}}

    <section class="dashboard-card">

        <div class="card-header">

            <div>
                <h3>My Appointments</h3>

                <p>
                    View and manage your scheduled consultations.
                </p>
            </div>

            <a
                href="{{ route('patient.appointments.create') }}"
                class="primary-button"
            >
                📅 Book Appointment
            </a>

        </div>


        {{-- Appointments --}}

        @if($appointments->count())

            <div class="appointments-list">

                @foreach($appointments as $appointment)

                    <div class="appointment-preview">

                        {{-- Date --}}

                        <div class="appointment-date">

                            <strong>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}
                            </strong>

                            <span>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}
                            </span>

                        </div>


                        {{-- Appointment Details --}}

                        <div class="appointment-details">

                            <h4>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}
                            </h4>

                            <p>
                                🕐
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </p>


                            {{-- Doctor --}}

                            @if($appointment->doctor && $appointment->doctor->user)

                                <p>
                                    👨‍⚕️
                                     {{ $appointment->doctor->user->name }}
                                </p>

                                @if($appointment->doctor->specialization)

                                    <p>
                                        🩺
                                        {{ $appointment->doctor->specialization }}
                                    </p>

                                @endif

                            @endif


                            {{-- Health Center --}}

                            @if($appointment->healthCenter)

                                <p>
                                    🏥
                                    {{ $appointment->healthCenter->name }}
                                </p>

                            @endif


                            {{-- Reason --}}

                            @if($appointment->reason)

                                <p>
                                    <strong>Reason:</strong>
                                    {{ $appointment->reason }}
                                </p>

                            @endif


                            {{-- Status --}}

                            <span class="appointment-status">
                                {{ ucfirst($appointment->status) }}
                            </span>


                            {{-- Cancel Button --}}

                            @if($appointment->status === 'pending')

                                <form
                                    method="POST"
                                    action="{{ route('patient.appointments.cancel', $appointment) }}"
                                    style="margin-top: 15px;"
                                    onsubmit="return confirm('Are you sure you want to cancel this appointment?');"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="secondary-button"
                                    >
                                        Cancel Appointment
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- No Appointments --}}

            <div class="empty-state">

                <div class="empty-icon">
                    📅
                </div>

                <h4>No appointments found</h4>

                <p>
                    You currently don't have any appointments.
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

@endsection