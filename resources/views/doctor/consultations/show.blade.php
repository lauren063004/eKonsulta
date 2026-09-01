@extends('layouts.dashboard')

@section('title', 'Consultation Details')

@section('page-title', 'Consultation Details')

@section('content')

    <div class="dashboard-card">

        <div class="card-header">

            <div>
                <h3>Consultation Details</h3>
                <p>Clinical consultation record</p>
            </div>

            <a href="{{ route('doctor.consultations.index') }}">
                Back to Consultations
            </a>

        </div>


        {{-- Patient Information --}}
        <div class="appointment-preview">

            <div class="appointment-date">

                <strong>👤</strong>

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

                @if($consultation->patient->user->email ?? false)

                    <p>
                        <strong>Email:</strong>
                        {{ $consultation->patient->user->email }}
                    </p>

                @endif

            </div>

        </div>


        {{-- Consultation Information --}}
        <div style="margin-top: 25px;">

            <h3>🩺 Consultation Information</h3>

            <p>
                <strong>Date:</strong>
                {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('F d, Y g:i A') }}
            </p>

            @if($consultation->appointment && $consultation->appointment->healthCenter)

                <p>
                    <strong>Health Center:</strong>
                    🏥 {{ $consultation->appointment->healthCenter->name }}
                </p>

            @endif

        </div>


        {{-- Clinical Findings --}}
        <div style="margin-top: 25px;">

            <h3>Clinical Findings</h3>

            @if($consultation->chief_complaint)

                <p>
                    <strong>Chief Complaint:</strong><br>
                    {{ $consultation->chief_complaint }}
                </p>

            @endif


            @if($consultation->symptoms)

                <p>
                    <strong>Symptoms:</strong><br>
                    {{ $consultation->symptoms }}
                </p>

            @endif


            @if($consultation->diagnosis)

                <p>
                    <strong>Diagnosis:</strong><br>
                    {{ $consultation->diagnosis }}
                </p>

            @endif


            @if($consultation->treatment_plan)

                <p>
                    <strong>Treatment Plan:</strong><br>
                    {{ $consultation->treatment_plan }}
                </p>

            @endif


            @if($consultation->notes)

                <p>
                    <strong>Additional Notes:</strong><br>
                    {{ $consultation->notes }}
                </p>

            @endif

        </div>


        {{-- Prescriptions --}}
        <div style="margin-top: 25px;">

            <h3>💊 Prescriptions</h3>

            @if($consultation->prescriptions->count())

                @foreach($consultation->prescriptions as $prescription)

                    <div class="appointment-preview">

                        <div class="appointment-date">

                            <strong>💊</strong>

                        </div>

                        <div class="appointment-details">

                            <h4>
                                Prescription
                            </h4>

                            <p>
                                <strong>Prescription No:</strong>
                                {{ $prescription->prescription_number }}
                            </p>

                            <p>
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('F d, Y') }}
                            </p>


                            @foreach($prescription->items as $item)

                                <p>
                                    <strong>
                                        {{ $item->medicine->name ?? 'Medicine' }}
                                    </strong><br>

                                    {{ $item->dosage }}
                                    —
                                    {{ $item->frequency }}
                                    —
                                    {{ $item->duration }}

                                    <br>

                                    Quantity:
                                    {{ $item->quantity }}

                                </p>

                            @endforeach


                            @if($prescription->instructions)

                                <p>
                                    <strong>Instructions:</strong>
                                    {{ $prescription->instructions }}
                                </p>

                            @endif

                        </div>

                    </div>

                @endforeach

            @else

                <p>
                    No prescriptions were issued for this consultation.
                </p>

            @endif

        </div>


        <div style="margin-top: 25px;">

            <a
                href="{{ route('doctor.consultations.index') }}"
                class="primary-button"
            >
                Back to Consultations
            </a>

        </div>

    </div>

@endsection