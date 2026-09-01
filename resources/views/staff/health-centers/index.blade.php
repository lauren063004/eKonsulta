@extends('layouts.dashboard')

@section('title', 'Health Centers')

@section('page-title', 'Health Centers')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Health Centers</h3>
            <p>View registered health centers and their information</p>
        </div>

        <a href="{{ route('staff.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($healthCenters->count())

        <div class="medical-records-list">

            @foreach($healthCenters as $healthCenter)

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

                        <p>
                            <strong>Doctors:</strong>
                            {{ $healthCenter->doctors->count() }}
                        </p>

                        <p>
                            <strong>Staff:</strong>
                            {{ $healthCenter->staff->count() }}
                        </p>

                        <div style="margin-top: 15px;">

                            <a
                                href="{{ route('staff.health-centers.show', $healthCenter) }}"
                                class="primary-button"
                            >
                                View Details
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
                🏥
            </div>

            <h4>No health centers found</h4>

            <p>
                Registered health centers will appear here.
            </p>

        </div>

    @endif

</div>

@endsection