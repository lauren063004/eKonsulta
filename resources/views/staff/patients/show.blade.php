@extends('layouts.dashboard')

@section('title', 'Patient Details')

@section('page-title', 'Patient Details')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Patient Details</h3>
            <p>Patient information and medical history</p>
        </div>

        <a href="{{ route('staff.patients.index') }}">
            Back to Patients
        </a>

    </div>


    {{-- PATIENT INFORMATION --}}

    <div class="appointment-details">

        <h3>
            {{ $patient->user->name ?? 'Patient' }}
        </h3>

        @if($patient->patient_number)
            <p>
                <strong>Patient No:</strong>
                {{ $patient->patient_number }}
            </p>
        @endif

        @if($patient->date_of_birth)
            <p>
                <strong>Date of Birth:</strong>
                {{ $patient->date_of_birth->format('F j, Y') }}
            </p>
        @endif

        @if($patient->sex)
            <p>
                <strong>Sex:</strong>
                {{ ucfirst($patient->sex) }}
            </p>
        @endif

        @if($patient->contact_number)
            <p>
                <strong>Contact Number:</strong>
                {{ $patient->contact_number }}
            </p>
        @endif

        @if($patient->address)
            <p>
                <strong>Address:</strong>
                {{ $patient->address }}
            </p>
        @endif

        @if($patient->emergency_contact_number)
            <p>
                <strong>Emergency Contact:</strong>
                {{ $patient->emergency_contact_number }}
            </p>
        @endif

    </div>


    {{-- APPOINTMENTS --}}

    <hr>

    <h3>?? Appointments</h3>

    @if($patient->appointments->count())

        @foreach($patient->appointments as $appointment)

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
                        {{ $appointment->appointment_date->format('F j, Y') }}
                    </h4>

                    @if($appointment->doctor && $appointment->doctor->user)
                        <p>
                            <strong>Doctor:</strong>
                            {{ $appointment->doctor->user->name }}
                        </p>
                    @endif

                    @if($appointment->healthCenter)
                        <p>
                            <strong>Health Center:</strong>
                            {{ $appointment->healthCenter->name }}
                        </p>
                    @endif

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

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <div class="empty-state">

            <div class="empty-icon">
                ??
            </div>

            <h4>No appointments</h4>

            <p>
                This patient has no appointment records yet.
            </p>

        </div>

    @endif


    {{-- CONSULTATIONS --}}

    <hr>

    <h3>?? Consultations</h3>

    @if($patient->consultations->count())

        @foreach($patient->consultations as $consultation)

            <div class="appointment-details">

                @if($consultation->consultation_date)
                    <p>
                        <strong>Date:</strong>
                        {{ $consultation->consultation_date->format('F j, Y g:i A') }}
                    </p>
                @endif

                @if($consultation->doctor && $consultation->doctor->user)
                    <p>
                        <strong>Doctor:</strong>
                        {{ $consultation->doctor->user->name }}
                    </p>
                @endif

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

            <hr>

        @endforeach

    @else

        <div class="empty-state">

            <div class="empty-icon">
                ??
            </div>

            <h4>No consultations</h4>

            <p>
                This patient has no consultation records yet.
            </p>

        </div>

    @endif


    {{-- PRESCRIPTIONS --}}

    <hr>

    <h3>?? Prescriptions</h3>

    @if($patient->prescriptions->count())

        @foreach($patient->prescriptions as $prescription)

            <div class="prescription-details">

                <h4>
                    Prescription {{ $prescription->prescription_number }}
                </h4>

                <p>
                    <strong>Date:</strong>
                    {{ $prescription->prescription_date->format('F j, Y') }}
                </p>

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


                @if($prescription->items->count())

                    <h4>Prescribed Medicines</h4>

                    @foreach($prescription->items as $item)

                        <div class="medicine-item">

                            @if($item->medicine)

                                <p>
                                    ??
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

            <hr>

        @endforeach

    @else

        <div class="empty-state">

            <div class="empty-icon">
                ??
            </div>

            <h4>No prescriptions</h4>

            <p>
                This patient has no prescription records yet.
            </p>

        </div>

    @endif


    <div style="margin-top: 20px;">

        <a
            href="{{ route('staff.patients.index') }}"
            class="primary-button"
        >
            Back to Patients
        </a>

    </div>

</div>

@endsection
