@extends('layouts.dashboard')

@section('title', 'Add Doctor')
@section('page-title', 'Add Doctor')

@section('content')

<div class="dashboard-card admin-doctor-form-page">

    <div class="card-header">
        <div>
            <h3>Add Doctor</h3>
            <p>Create a new doctor account for the e-Konsulta system</p>
        </div>

        <a href="{{ route('admin.doctors.index') }}">
            Back to Doctors
        </a>
    </div>

    @if($errors->any())
        <div class="form-error-box">
            <strong>Please correct the following errors:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.doctors.store') }}"
        class="admin-doctor-form"
    >
        @csrf

        <div class="admin-doctor-form-grid">

            <div class="admin-doctor-form-field">
                <label for="name">Doctor Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter doctor's full name"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter doctor's email"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create account password"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="password_confirmation">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm account password"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="health_center_id">Health Center</label>

                <select
                    id="health_center_id"
                    name="health_center_id"
                    required
                >
                    <option value="">Select health center</option>

                    @foreach($healthCenters as $healthCenter)
                        <option
                            value="{{ $healthCenter->id }}"
                            {{ old('health_center_id') == $healthCenter->id ? 'selected' : '' }}
                        >
                            {{ $healthCenter->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="admin-doctor-form-field">
                <label for="license_number">License Number</label>

                <input
                    type="text"
                    id="license_number"
                    name="license_number"
                    value="{{ old('license_number') }}"
                    placeholder="e.g. MD-2026-00002"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="specialization">Specialization</label>

                <input
                    type="text"
                    id="specialization"
                    name="specialization"
                    value="{{ old('specialization') }}"
                    placeholder="e.g. General Medicine"
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="contact_number">Contact Number</label>

                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number') }}"
                    placeholder="e.g. 09175555555"
                >
            </div>

        </div>

        <div class="admin-doctor-form-actions">

            <a
                href="{{ route('admin.doctors.index') }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                Create Doctor
            </button>

        </div>

    </form>

</div>

@endsection