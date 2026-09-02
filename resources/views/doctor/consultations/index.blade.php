@extends('layouts.dashboard')

@section('title', 'My Consultations')

@section('page-title', 'My Consultations')

@section('content')

<div class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>My Consultations</h3>
            <p>Consultation records for your patients</p>
        </div>

        <a href="{{ route('doctor.dashboard') }}">
            Back to Dashboard
        </a>
    </div>

    @if($consultations->count())

        <div class="consultation-list">

            @foreach($consultations as $consultation)

                <div class="consultation-list-card">

                    <div class="consultation-list-date">
                        <strong>
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M') }}
                        </strong>

                        <span>
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d') }}
                        </span>
                    </div>

                    <div class="consultation-list-content">

                        <div class="consultation-list-header">

                            <div>
                                <span class="consultation-list-label">
                                    PATIENT CONSULTATION
                                </span>

                                <h4>
                                    {{ $consultation->patient->user->name ?? 'Patient' }}
                                </h4>

                                @if($consultation->patient)
                                    <p>
                                        {{ $consultation->patient->patient_number }}
                                    </p>
                                @endif
                            </div>

                        </div>

                        <div class="consultation-list-information">

                            <div>
                                <span>Date & Time</span>
                                <strong>
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('F j, Y') }}
                                    —
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('g:i A') }}
                                </strong>
                            </div>

                            @if($consultation->chief_complaint)
                                <div>
                                    <span>Chief Complaint</span>
                                    <strong>
                                        {{ $consultation->chief_complaint }}
                                    </strong>
                                </div>
                            @endif

                            @if($consultation->symptoms)
                                <div>
                                    <span>Symptoms</span>
                                    <strong>
                                        {{ $consultation->symptoms }}
                                    </strong>
                                </div>
                            @endif

                            @if($consultation->diagnosis)
                                <div>
                                    <span>Diagnosis</span>
                                    <strong>
                                        {{ $consultation->diagnosis }}
                                    </strong>
                                </div>
                            @endif

                            @if($consultation->treatment_plan)
                                <div>
                                    <span>Treatment Plan</span>
                                    <strong>
                                        {{ $consultation->treatment_plan }}
                                    </strong>
                                </div>
                            @endif

                            @if($consultation->appointment && $consultation->appointment->healthCenter)
                                <div>
                                    <span>Health Center</span>
                                    <strong>
                                        {{ $consultation->appointment->healthCenter->name }}
                                    </strong>
                                </div>
                            @endif

                            @if($consultation->prescriptions->count())
                                <div>
                                    <span>Prescription</span>
                                    <strong>
                                        {{ $consultation->prescriptions->count() }}
                                    </strong>
                                </div>
                            @endif

                        </div>

                        @if($consultation->notes)

                            <div class="consultation-list-information">

                                <div>
                                    <span>Additional Notes</span>
                                    <strong>
                                        {{ $consultation->notes }}
                                    </strong>
                                </div>

                            </div>

                        @endif

                        <div class="consultation-list-action">

                            <a
                                href="{{ route('doctor.consultations.show', $consultation) }}"
                                class="primary-button"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                &#129658;
            </div>

            <h4>No consultations yet</h4>

            <p>
                Consultation records you create for your
                patients will appear here.
            </p>

        </div>

    @endif

</div>

@endsection