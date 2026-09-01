@extends('layouts.dashboard')

@section('title', 'Consultations')

@section('page-title', 'Consultations')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>All Consultations</h3>
            <p>View patient consultation records</p>
        </div>

        <a href="{{ route('staff.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($consultations->count())

        <div class="medical-records-list">

            @foreach($consultations as $consultation)

                <div class="appointment-preview">

                    <div class="appointment-date">

                        <strong>
                            {{ $consultation->consultation_date->format('M') }}
                        </strong>

                        <span>
                            {{ $consultation->consultation_date->format('d') }}
                        </span>

                    </div>

                    <div class="appointment-details">

                        <h4>
                            {{ $consultation->patient->user->name ?? 'Patient' }}
                        </h4>

                        @if($consultation->patient)

                            <p>
                                <strong>Patient No:</strong>
                                {{ $consultation->patient->patient_number }}
                            </p>

                        @endif

                        @if($consultation->doctor && $consultation->doctor->user)

                            <p>
                                <strong>Doctor:</strong>
                                {{ $consultation->doctor->user->name }}
                            </p>

                        @endif

                        <p>
                            <strong>Date:</strong>
                            {{ $consultation->consultation_date->format('F j, Y g:i A') }}
                        </p>

                        @if($consultation->chief_complaint)

                            <p>
                                <strong>Chief Complaint:</strong>
                                {{ $consultation->chief_complaint }}
                            </p>

                        @endif

                        @if($consultation->diagnosis)

                            <p>
                                <strong>Diagnosis:</strong>
                                {{ $consultation->diagnosis }}
                            </p>

                        @endif

                        <div style="margin-top: 15px;">

                            <a
                                href="{{ route('staff.consultations.show', $consultation) }}"
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
                🩺
            </div>

            <h4>No consultations yet</h4>

            <p>
                Patient consultation records will appear here.
            </p>

        </div>

    @endif

</div>

@endsection