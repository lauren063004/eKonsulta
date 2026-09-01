@extends('layouts.dashboard')

@section('title', 'Medical Records')

@section('page-title', 'Medical Records')

@section('content')

<div class="dashboard-card">


<div class="card-header">

    <div>
        <h3>My Medical Records</h3>
        <p>Your consultation and treatment history</p>
    </div>

    <a href="{{ route('patient.dashboard') }}">
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
                        {{ $consultation->consultation_date->format('l, F j, Y') }}
                    </h4>

                    {{-- Doctor --}}
                    @if($consultation->doctor && $consultation->doctor->user)

                        <p>
                            👨‍⚕️
                          {{ $consultation->doctor->user->name }}
                        </p>

                    @endif

                    {{-- Specialization --}}
                    @if($consultation->doctor && $consultation->doctor->specialization)

                        <p>
                            🩺
                            {{ $consultation->doctor->specialization }}
                        </p>

                    @endif

                    {{-- Health Center --}}
                    @if($consultation->appointment && $consultation->appointment->healthCenter)

                        <p>
                            🏥
                            {{ $consultation->appointment->healthCenter->name }}
                        </p>

                    @endif

                    {{-- Chief Complaint --}}
                    @if($consultation->chief_complaint)

                        <p>
                            <strong>Chief Complaint:</strong>
                            {{ $consultation->chief_complaint }}
                        </p>

                    @endif

                    {{-- Symptoms --}}
                    @if($consultation->symptoms)

                        <p>
                            <strong>Symptoms:</strong>
                            {{ $consultation->symptoms }}
                        </p>

                    @endif

                    {{-- Diagnosis --}}
                    @if($consultation->diagnosis)

                        <p>
                            <strong>Diagnosis:</strong>
                            {{ $consultation->diagnosis }}
                        </p>

                    @endif

                    {{-- Treatment Plan --}}
                    @if($consultation->treatment_plan)

                        <p>
                            <strong>Treatment Plan:</strong>
                            {{ $consultation->treatment_plan }}
                        </p>

                    @endif

                    {{-- Doctor's Notes --}}
                    @if($consultation->notes)

                        <p>
                            <strong>Doctor's Notes:</strong>
                            {{ $consultation->notes }}
                        </p>

                    @endif


                    {{-- PRESCRIPTIONS --}}
                    @if($consultation->prescriptions->count())

                        <hr>

                        <h4>💊 Prescriptions</h4>

                        @foreach($consultation->prescriptions as $prescription)

                            <div class="prescription-details">

                                <p>
                                    <strong>Prescription No:</strong>
                                    {{ $prescription->prescription_number }}
                                </p>

                                <p>
                                    <strong>Date:</strong>
                                    {{ $prescription->prescription_date->format('F j, Y') }}
                                </p>

                                <p>
                                    <strong>Status:</strong>
                                    {{ ucfirst($prescription->status) }}
                                </p>

                                {{-- General Instructions --}}
                                @if($prescription->instructions)

                                    <p>
                                        <strong>General Instructions:</strong>
                                        {{ $prescription->instructions }}
                                    </p>

                                @endif


                                {{-- Medicines --}}
                                @if($prescription->items->count())

                                    <h4>Medicines</h4>

                                    @foreach($prescription->items as $item)

                                        <div class="medicine-item">

                                            @if($item->medicine)

                                                <p>
                                                    💊
                                                    <strong>
                                                        {{ $item->medicine->name }}
                                                    </strong>

                                                    @if($item->medicine->generic_name)
                                                        ({{ $item->medicine->generic_name }})
                                                    @endif
                                                </p>

                                                @if($item->medicine->strength || $item->medicine->dosage_form)

                                                    <p>
                                                        <strong>Medicine:</strong>

                                                        @if($item->medicine->strength)
                                                            {{ $item->medicine->strength }}
                                                        @endif

                                                        @if($item->medicine->dosage_form)
                                                            — {{ $item->medicine->dosage_form }}
                                                        @endif
                                                    </p>

                                                @endif

                                            @endif


                                            @if($item->dosage)

                                                <p>
                                                    <strong>Dosage:</strong>
                                                    {{ $item->dosage }}
                                                </p>

                                            @endif


                                            @if($item->frequency)

                                                <p>
                                                    <strong>Frequency:</strong>
                                                    {{ $item->frequency }}
                                                </p>

                                            @endif


                                            @if($item->duration)

                                                <p>
                                                    <strong>Duration:</strong>
                                                    {{ $item->duration }}
                                                </p>

                                            @endif


                                            @if($item->quantity)

                                                <p>
                                                    <strong>Quantity:</strong>
                                                    {{ $item->quantity }}
                                                </p>

                                            @endif


                                            @if($item->instructions)

                                                <p>
                                                    <strong>Instructions:</strong>
                                                    {{ $item->instructions }}
                                                </p>

                                            @endif

                                        </div>

                                    @endforeach

                                @endif

                            </div>

                        @endforeach

                    @endif

                </div>

            </div>

            <hr>

        @endforeach

    </div>

@else

    <div class="empty-state">

        <div class="empty-icon">
            📋
        </div>

        <h4>No medical records yet</h4>

        <p>
            Your consultation and treatment records will appear here
            after you have completed a consultation.
        </p>

    </div>

@endif


</div>

@endsection
