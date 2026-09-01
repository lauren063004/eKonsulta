@extends('layouts.dashboard')

@section('title', 'My Prescriptions')

@section('page-title', 'Prescriptions')

@section('content')

<div class="dashboard-card">


<div class="card-header">

    <div>
        <h3>My Prescriptions</h3>
        <p>View your prescribed medicines and instructions</p>
    </div>

    <a href="{{ route('patient.dashboard') }}">
        Back to Dashboard
    </a>

</div>


@if($prescriptions->count())

    <div class="medical-records-list">

        @foreach($prescriptions as $prescription)

            <div class="appointment-preview">

                <div class="appointment-date">

                    <strong>
                        {{ $prescription->prescription_date->format('M') }}
                    </strong>

                    <span>
                        {{ $prescription->prescription_date->format('d') }}
                    </span>

                </div>


                <div class="appointment-details">

                    <h4>
                        Prescription {{ $prescription->prescription_number }}
                    </h4>

                    <p>
    📅
    {{ $prescription->prescription_date->format('l, F j, Y') }}
</p>

                    {{-- Doctor --}}

                    @if($prescription->doctor && $prescription->doctor->user)

                        <p>
    👨‍⚕️
    {{ $prescription->doctor->user->name }}
</p>

                    @endif


                    {{-- Consultation Diagnosis --}}

                    @if($prescription->consultation && $prescription->consultation->diagnosis)

                  <p>
    🩺
    <strong>Diagnosis:</strong>
                            {{ $prescription->consultation->diagnosis }}
                        </p>

                    @endif


                    {{-- Status --}}

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($prescription->status) }}
                    </p>


                    {{-- General Instructions --}}

                    @if($prescription->instructions)

                        <div class="prescription-details">

                            <p>
                                <strong>General Instructions:</strong>
                            </p>

                            <p>
                                {{ $prescription->instructions }}
                            </p>

                        </div>

                    @endif


                    {{-- Medicines --}}

                    @if($prescription->items->count())

                        <hr>

                        <h4>💊 Prescribed Medicines</h4>

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
                                        <strong>Medicine Instructions:</strong>
                                        {{ $item->instructions }}
                                    </p>

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
            💊
        </div>

        <h4>No prescriptions yet</h4>

        <p>
            Your prescriptions will appear here after your doctor
            prescribes medicine during a consultation.
        </p>

    </div>

@endif


</div>

@endsection
