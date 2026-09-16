@extends('layouts.dashboard')

@section('title', 'My Prescriptions')

@section('page-title', 'My Prescriptions')

@section('content')

<div class="dashboard-card doctor-prescriptions-page">

    <div class="card-header">
        <div>
            <h3>My Prescriptions</h3>
            <p>Prescriptions issued to your patients</p>
        </div>

        <a href="{{ route('doctor.dashboard') }}">
            Back to Dashboard
        </a>
    </div>

    @if($prescriptions->count())

        <div class="doctor-prescription-list">

            @foreach($prescriptions as $prescription)

                <div class="doctor-prescription-card">

                    <div class="doctor-prescription-header">

                        <div class="doctor-prescription-date">

                            <div class="doctor-prescription-icon">
                                &#128138;
                            </div>

                            <div>
                                <span class="doctor-prescription-label">
                                    PRESCRIPTION
                                </span>

                                <h4>
                                    {{ $prescription->patient->user->name ?? 'Patient' }}
                                </h4>

                                <p>
                                    {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('F d, Y') }}
                                </p>
                            </div>

                        </div>

                        <span class="appointment-status">
                            {{ ucfirst($prescription->status) }}
                        </span>

                    </div>

                    <div class="doctor-prescription-information">

                        <div>
                            <span>Prescription No.</span>
                            <strong>
                                {{ $prescription->prescription_number }}
                            </strong>
                        </div>

                        <div>
                            <span>Date Issued</span>
                            <strong>
                                {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('F d, Y') }}
                            </strong>
                        </div>

                    </div>

                    @if($prescription->items->count())

                        <div class="doctor-prescription-medicines">

                            <div class="doctor-prescription-section-title">
                                <span>MEDICATIONS</span>
                                <strong>Prescribed Medicines</strong>
                            </div>

                            <div class="doctor-prescription-items">

                                @foreach($prescription->items as $item)

                                    <div class="doctor-prescription-item">

                                        <div class="doctor-prescription-medicine-name">
                                            <strong>
                                                {{ $item->medicine->name ?? 'Medicine' }}
                                            </strong>
                                        </div>

                                        <div class="doctor-prescription-medicine-details">

                                            <span>
                                                <strong>Dosage:</strong>
                                                {{ $item->dosage }}
                                            </span>

                                            <span>
                                                <strong>Frequency:</strong>
                                                {{ $item->frequency }}
                                            </span>

                                            <span>
                                                <strong>Duration:</strong>
                                                {{ $item->duration }}
                                            </span>

                                            <span>
                                                <strong>Quantity:</strong>
                                                {{ $item->quantity }}
                                            </span>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif

                    @if($prescription->instructions)

                        <div class="doctor-prescription-instructions">

                            <span>INSTRUCTIONS</span>

                            <p>
                                {{ $prescription->instructions }}
                            </p>

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                &#128138;
            </div>

            <h4>No prescriptions yet</h4>

            <p>
                Prescriptions you create for your patients
                will appear here.
            </p>

        </div>

    @endif

</div>

@endsection