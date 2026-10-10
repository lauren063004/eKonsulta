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

        <x-list-search target="patient-medical-record-list" placeholder="Search doctor, diagnosis, treatment, or date..." label="Search your medical records" />

        <div class="medical-records-list" id="patient-medical-record-list">

            @foreach($consultations as $consultation)

                <div class="appointment-preview" data-search-item>

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
                               
                                {{ $consultation->doctor->user->name }}
                            </p>

                        @endif

                        {{-- Specialization --}}
                        @if($consultation->doctor && $consultation->doctor->specialization)

                            <p>
                                ðŸ©º
                                {{ $consultation->doctor->specialization }}
                            </p>

                        @endif

                        {{-- Health Center --}}
                        @if($consultation->appointment && $consultation->appointment->healthCenter)

                            <p>
                                ðŸ¥
                                {{ $consultation->appointment->healthCenter->name }}
                            </p>

                        @endif

                        {{-- PATIENT INTAKE --}}
                        @if($consultation->appointment && $consultation->appointment->patientIntake)

                            <hr>

                            <h4>Patient Intake</h4>

                            <div class="detail-grid">

                                @if($consultation->appointment->patientIntake->height !== null)
                                    <p>
                                        <strong>Height:</strong>
                                        {{ number_format((float) $consultation->appointment->patientIntake->height, 2) }} cm
                                    </p>
                                @endif

                                @if($consultation->appointment->patientIntake->weight !== null)
                                    <p>
                                        <strong>Weight:</strong>
                                        {{ number_format((float) $consultation->appointment->patientIntake->weight, 2) }} kg
                                    </p>
                                @endif

                                @php
                                    $height = (float) $consultation->appointment->patientIntake->height;
                                    $weight = (float) $consultation->appointment->patientIntake->weight;
                                    $bmi = $height > 0
                                        ? $weight / (($height / 100) ** 2)
                                        : null;
                                @endphp

                                @if($bmi !== null)
                                    <p>
                                        <strong>BMI:</strong>
                                        {{ number_format($bmi, 2) }}
                                    </p>
                                @endif

                                <p>
                                    <strong>Diabetes:</strong>
                                    {{ $consultation->appointment->patientIntake->has_diabetes ? 'Yes' : 'No' }}
                                </p>

                                <p>
                                    <strong>Hypertension:</strong>
                                    {{ $consultation->appointment->patientIntake->has_hypertension ? 'Yes' : 'No' }}
                                </p>

                            </div>

                            @if($consultation->appointment->patientIntake->allergies)
                                <p>
                                    <strong>Allergies:</strong>
                                    {{ $consultation->appointment->patientIntake->allergies }}
                                </p>
                            @endif

                            @if($consultation->appointment->patientIntake->comorbidities)
                                <p>
                                    <strong>Comorbidities:</strong>
                                    {{ $consultation->appointment->patientIntake->comorbidities }}
                                </p>
                            @endif

                            @if($consultation->appointment->patientIntake->maintenance_medications)
                                <p>
                                    <strong>Maintenance Medications:</strong>
                                    {{ $consultation->appointment->patientIntake->maintenance_medications }}
                                </p>
                            @endif

                            @if($consultation->appointment->patientIntake->other_medical_information)
                                <p>
                                    <strong>Other Medical Information:</strong>
                                    {{ $consultation->appointment->patientIntake->other_medical_information }}
                                </p>
                            @endif

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

                            <h4>ðŸ’Š Prescriptions</h4>

                            @foreach($consultation->prescriptions as $prescription)

                                <div class="prescription-details">

                                    <div class="detail-grid">

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

                                    </div>

                                    {{-- General Instructions --}}
                                    @if($prescription->instructions)

                                        <p>
                                            <strong>General Instructions:</strong>
                                            {{ $prescription->instructions }}
                                        </p>

                                    @endif


                                    {{-- Medicines --}}
                                    @if($prescription->items->count())

                                        <h4 style="margin-top:12px;">Medicines</h4>

                                        @foreach($prescription->items as $item)

                                            <div class="medicine-item">

                                                @if($item->medicine)

                                                    <p>
                                                        ðŸ’Š
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
                                                                â€” {{ $item->medicine->dosage_form }}
                                                            @endif
                                                        </p>

                                                    @endif

                                                @endif


                                                <div class="detail-grid">

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

                                                </div>


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

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                ðŸ“‹
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