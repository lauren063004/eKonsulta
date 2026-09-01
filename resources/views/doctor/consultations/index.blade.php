@extends('layouts.dashboard')

@section('title', 'My Consultations')

@section('page-title', 'My Consultations')

@section('content')

```
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

        <div class="medical-records-list">

            @foreach($consultations as $consultation)

                <div class="appointment-preview">

                    <div class="appointment-date">

                        <strong>🩺</strong>

                        <span>
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M d') }}
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

    <p>
        <strong>Date:</strong>
        {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('F d, Y g:i A') }}
    </p>

    @if($consultation->chief_complaint)

        <p>
            <strong>Chief Complaint:</strong>
            {{ $consultation->chief_complaint }}
        </p>

    @endif

    @if($consultation->symptoms)

        <p>
            <strong>Symptoms:</strong>
            {{ $consultation->symptoms }}
        </p>

    @endif

    @if($consultation->diagnosis)

        <p>
            <strong>Diagnosis:</strong>
            {{ $consultation->diagnosis }}
        </p>

    @endif

    @if($consultation->treatment_plan)

        <p>
            <strong>Treatment Plan:</strong>
            {{ $consultation->treatment_plan }}
        </p>

    @endif

    @if($consultation->notes)

        <p>
            <strong>Additional Notes:</strong>
            {{ $consultation->notes }}
        </p>

    @endif

    @if($consultation->appointment && $consultation->appointment->healthCenter)

        <p>
            <strong>Health Center:</strong>
            🏥 {{ $consultation->appointment->healthCenter->name }}
        </p>

    @endif

    @if($consultation->prescriptions->count())

        <p>
            <strong>Prescription:</strong>
            💊 {{ $consultation->prescriptions->count() }}
        </p>

    @endif

    <div style="margin-top: 15px;">

        <a
            href="{{ route('doctor.consultations.show', $consultation) }}"
            class="primary-button"
        >
            View Details
        </a>

    </div>

</div>

                </div>

                @if(!$loop->last)
                    <hr>
                @endif

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                🩺
            </div>

            <h4>No consultations yet</h4>

            <p>
                Consultation records you create for your
                patients will appear here.
            </p>

        </div>

    @endif

</div>
```

@endsection
