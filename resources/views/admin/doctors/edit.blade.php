@extends('layouts.dashboard')

@section('title', 'Edit Doctor')
@section('page-title', 'Edit Doctor')

@section('content')

<div class="dashboard-card admin-doctor-form-page">

    <div class="card-header">
        <div>
            <h3>Edit Doctor</h3>
            <p>Update doctor account, professional information, and services</p>
        </div>

        <a href="{{ route('admin.doctors.show', $doctor) }}">
            Back to Doctor Details
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
        action="{{ route('admin.doctors.update', $doctor) }}"
        class="admin-doctor-form"
    >
        @csrf
        @method('PUT')

        <div class="admin-doctor-form-grid">

            <div class="admin-doctor-form-field">
                <label for="name">Doctor Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $doctor->user->name) }}"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $doctor->user->email) }}"
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
                    @foreach($healthCenters as $healthCenter)
                        <option
                            value="{{ $healthCenter->id }}"
                            {{ old('health_center_id', $doctor->health_center_id) == $healthCenter->id ? 'selected' : '' }}
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
                    value="{{ old('license_number', $doctor->license_number) }}"
                    required
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="specialization">Specialization</label>

                <input
                    type="text"
                    id="specialization"
                    name="specialization"
                    value="{{ old('specialization', $doctor->specialization) }}"
                >
            </div>

            <div class="admin-doctor-form-field">
                <label for="contact_number">Contact Number</label>

                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number', $doctor->contact_number) }}"
                >
            </div>

        </div>

        {{-- DOCTOR SERVICES --}}

        <div class="admin-doctor-services-section">

            <div class="admin-doctor-services-heading">
                <div>
                    <h4>Services Provided</h4>
                    <p>
                        Select the active services this doctor provides at
                        {{ $doctor->healthCenter?->name ?? 'their health center' }}.
                    </p>
                </div>
            </div>

            @if($services->isNotEmpty())

                <div class="admin-doctor-services-grid">

                    @foreach($services as $service)

                        <label class="admin-doctor-service-option">

                            <input
                                type="checkbox"
                                name="services[]"
                                value="{{ $service->id }}"
                                {{ $doctor->services->contains($service->id) ? 'checked' : '' }}
                            >

                            <span class="admin-doctor-service-content">

                                <strong>
                                    {{ $service->name }}
                                </strong>

                                <small>
                                    {{ $service->code }}
                                </small>

                                @if($service->description)
                                    <span>
                                        {{ $service->description }}
                                    </span>
                                @endif

                            </span>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="empty-state">
                    <div class="empty-icon">🩺</div>
                    <h4>No services available</h4>
                    <p>
                        Assign services to this doctor's health center first.
                    </p>
                </div>

            @endif

        </div>

        <div class="admin-doctor-form-actions">

            <a
                href="{{ route('admin.doctors.show', $doctor) }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection