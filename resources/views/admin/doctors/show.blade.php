@extends('layouts.dashboard')

@section('title', 'Doctor Details')
@section('page-title', 'Doctor Details')

@section('content')

<div class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>Doctor Details</h3>
            <p>View doctor account and professional information</p>
        </div>

        <div class="admin-doctor-header-actions">
            <a href="{{ route('admin.doctors.index') }}">
                Back to Doctors
            </a>

            <a
                href="{{ route('admin.doctors.edit', $doctor) }}"
                class="primary-button"
            >
                Edit Doctor
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-doctor-details">

        <div class="admin-doctor-profile">

            <div class="admin-doctor-large-avatar">
                &#128104;&#8205;&#9877;
            </div>

            <div>
                <span class="admin-doctor-label">
                    DOCTOR
                </span>

                <h2>{{ $doctor->user->name }}</h2>

                <span class="user-status-badge {{ $doctor->user->status === 'active' ? 'active' : 'inactive' }}">
                    {{ ucfirst($doctor->user->status) }}
                </span>
            </div>

        </div>

        <div class="admin-doctor-detail-grid">

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    Email Address
                </span>

                <strong>
                    {{ $doctor->user->email }}
                </strong>
            </div>

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    License Number
                </span>

                <strong>
                    {{ $doctor->license_number }}
                </strong>
            </div>

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    Specialization
                </span>

                <strong>
                    {{ $doctor->specialization ?: 'Not specified' }}
                </strong>
            </div>

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    Contact Number
                </span>

                <strong>
                    {{ $doctor->contact_number ?: 'Not provided' }}
                </strong>
            </div>

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    Health Center
                </span>

                <strong>
                    {{ $doctor->healthCenter->name }}
                </strong>
            </div>

            <div class="admin-doctor-detail-card">
                <span class="admin-doctor-detail-label">
                    Account Created
                </span>

                <strong>
                    {{ $doctor->user->created_at?->format('F d, Y') }}
                </strong>
            </div>

        </div>

    </div>

    <div class="admin-doctor-detail-actions">

        <a
            href="{{ route('admin.doctors.index') }}"
            class="secondary-button"
        >
            Back to Doctor List
        </a>

        <form
            method="POST"
            action="{{ route('admin.doctors.toggle-status', $doctor) }}"
        >
            @csrf
            @method('PATCH')

            <button
                type="submit"
                class="status-button {{ $doctor->user->status === 'active' ? 'deactivate' : 'activate' }}"
            >
                {{ $doctor->user->status === 'active' ? 'Deactivate Doctor' : 'Activate Doctor' }}
            </button>
        </form>

    </div>

</div>

@endsection