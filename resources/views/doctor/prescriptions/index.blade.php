@extends('layouts.dashboard')

@section('title', 'My Prescriptions')

@section('page-title', 'My Prescriptions')

@section('content')

    <div class="dashboard-card">

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

            <div class="medical-records-list">

                @foreach($prescriptions as $prescription)

                    <div class="appointment-preview">

                        <div class="appointment-date">
                            <strong>💊</strong>

                            <span>
                                {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('M d') }}
                            </span>
                        </div>


                        <div class="appointment-details">

                            <h4>
                                {{ $prescription->patient->user->name ?? 'Patient' }}
                            </h4>

                            <p>
                                <strong>Prescription No:</strong>
                                {{ $prescription->prescription_number }}
                            </p>

                            <p>
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('F d, Y') }}
                            </p>


                            @if($prescription->items->count())

                                <div style="margin-top: 10px;">

                                    <strong>Medicines:</strong>

                                    @foreach($prescription->items as $item)

                                        <div style="margin-top: 8px;">

                                            <strong>
                                                {{ $item->medicine->name ?? 'Medicine' }}
                                            </strong>

                                            <br>

                                            <span>
                                                {{ $item->dosage }}
                                                —
                                                {{ $item->frequency }}
                                                —
                                                {{ $item->duration }}
                                            </span>

                                            <br>

                                            <span>
                                                Quantity:
                                                {{ $item->quantity }}
                                            </span>

                                        </div>

                                    @endforeach

                                </div>

                            @endif


                            @if($prescription->instructions)

                                <p style="margin-top: 10px;">
                                    <strong>Instructions:</strong>
                                    {{ $prescription->instructions }}
                                </p>

                            @endif


                            <span class="appointment-status">
                                {{ ucfirst($prescription->status) }}
                            </span>

                        </div>

                    </div>

                    <hr>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    💊
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