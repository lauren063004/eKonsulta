@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>My Profile</h3>
            <p>View and update your personal information</p>
        </div>

        <a href="{{ route('patient.dashboard') }}">
            Back to Dashboard
        </a>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div style="
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #e8f5e9;
        ">
            {{ session('success') }}
        </div>

    @endif


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())

        <div style="
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #ffebee;
        ">

            <strong>Please correct the following:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- ACCOUNT INFORMATION --}}

    <h3>Account Information</h3>

    <div class="appointment-details">

        <p>
            <strong>Name:</strong>
            {{ $user->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $user->email }}
        </p>

    </div>


    <hr>


    {{-- PATIENT INFORMATION --}}

    <h3>Patient Information</h3>

    @if($patient)

        <div class="appointment-details">

            <p>
                <strong>Patient No:</strong>
                {{ $patient->patient_number }}
            </p>

            <p>
                <strong>Date of Birth:</strong>
                {{ $patient->date_of_birth?->format('F j, Y') ?? 'Not provided' }}
            </p>

            <p>
                <strong>Sex:</strong>
                {{ $patient->sex ?? 'Not provided' }}
            </p>

        </div>


        <hr>


        {{-- EDITABLE PROFILE --}}

        <h3>Contact Information</h3>

        <form
            action="{{ route('patient.profile.update') }}"
            method="POST"
        >

            @csrf
            @method('PATCH')


            <div style="margin-bottom: 15px;">

                <label for="name">
                    <strong>Name</strong>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >

            </div>


            <div style="margin-bottom: 15px;">

                <label for="email">
                    <strong>Email</strong>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >

            </div>


            <div style="margin-bottom: 15px;">

                <label for="contact_number">
                    <strong>Contact Number</strong>
                </label>

                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number', $patient->contact_number) }}"
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >

            </div>


            <div style="margin-bottom: 15px;">

                <label for="address">
                    <strong>Address</strong>
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >{{ old('address', $patient->address) }}</textarea>

            </div>


            <hr>


            <h3>Emergency Contact</h3>


            <div style="margin-bottom: 15px;">

                <label for="emergency_contact_name">
                    <strong>Emergency Contact Name</strong>
                </label>

                <input
                    type="text"
                    id="emergency_contact_name"
                    name="emergency_contact_name"
                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >

            </div>


            <div style="margin-bottom: 20px;">

                <label for="emergency_contact_number">
                    <strong>Emergency Contact Number</strong>
                </label>

                <input
                    type="text"
                    id="emergency_contact_number"
                    name="emergency_contact_number"
                    value="{{ old('emergency_contact_number', $patient->emergency_contact_number) }}"
                    style="width: 100%; padding: 10px; margin-top: 5px;"
                >

            </div>


            <button
                type="submit"
                class="primary-button"
            >
                Save Changes
            </button>

        </form>

    @else

        <div class="empty-state">

            <h4>Patient record not found</h4>

            <p>
                Your patient profile has not been set up yet.
            </p>

        </div>

    @endif


    <div style="margin-top: 20px;">

        <a
            href="{{ route('patient.dashboard') }}"
            class="primary-button"
        >
            Back to Dashboard
        </a>

    </div>

</div>

@endsection