@extends('layouts.dashboard')

@section('title', 'Consultation Details')

@section('page-title', 'Consultation Details')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Consultation Details</h3>
            <p>Patient consultation information</p>
        </div>

        <a href="{{ route('staff.consultations.index') }}">
            Back to Consultations
        </a>

    </div>


    {{-- PATIENT INFORMATION --}}

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


        @if($consultation->appointment && $consultation->appointment->healthCenter)

            <p>
                <strong>Health Center:</strong>
                🏥 {{ $consultation->appointment->healthCenter->name }}
            </p>

        @endif


        @if($consultation->consultation_date)

            <p>
                <strong>Consultation Date:</strong>
                {{ $consultation->consultation_date->format('F j, Y g:i A') }}
            </p>

        @endif

    </div>


    {{-- CONSULTATION INFORMATION --}}

    <hr>

    <h3>🩺 Consultation</h3>

    <div class="appointment-details">

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
                <strong>Doctor's Notes:</strong>
                {{ $consultation->notes }}
            </p>

        @endif

    </div>


    {{-- PRESCRIPTIONS --}}

    @if($consultation->prescriptions->count())

        <hr>

        <h3>💊 Prescriptions</h3>

        @foreach($consultation->prescriptions as $prescription)

            <div class="prescription-details">

                <h4>
                    Prescription {{ $prescription->prescription_number }}
                </h4>


                @if($prescription->prescription_date)

                    <p>
                        <strong>Date:</strong>
                        {{ $prescription->prescription_date->format('F j, Y') }}
                    </p>

                @endif


                <p>
                    <strong>Status:</strong>
                    {{ ucfirst($prescription->status) }}
                </p>


                @if($prescription->instructions)

                    <p>
                        <strong>General Instructions:</strong>
                        {{ $prescription->instructions }}
                    </p>

                @endif


                {{-- MEDICINES --}}

                @if($prescription->items->count())

                    <h4>Prescribed Medicines</h4>

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

    @else

        <hr>

        <div class="empty-state">

            <h4>No prescriptions</h4>

            <p>
                No prescriptions were issued for this consultation.
            </p>

        </div>

    @endif


    <div style="margin-top: 20px;">

        <a
            href="{{ route('staff.consultations.index') }}"
            class="primary-button"
        >
            Back to Consultations
        </a>

    </div>

</div>

@endsection