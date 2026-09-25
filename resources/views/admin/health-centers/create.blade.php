@extends('layouts.dashboard')

@section('title', 'Add Health Center')

@section('page-title', 'Add Health Center')

@section('content')

<div class="dashboard-card admin-health-center-form-page">

    <div class="card-header">

        <div>
            <h3>Add Health Center</h3>
            <p>Register a new barangay health center</p>
        </div>

        <a href="{{ route('admin.health-centers.index') }}">
            Back to Health Centers
        </a>

    </div>

    <form
        method="POST"
        action="{{ route('admin.health-centers.store') }}"
        class="admin-health-center-form"
    >

        @csrf

        @if($errors->any())

            <div class="form-error-box">

                <strong>Please correct the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <div class="admin-health-center-form-grid">

            <div class="admin-health-center-form-field">

                <label for="name">
                    Health Center Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Pembo Health Center"
                    required
                >

            </div>

            <div class="admin-health-center-form-field">

                <label for="address">
                    Address
                </label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder="e.g. Pembo, Taguig City"
                    required
                >

            </div>

            <div class="admin-health-center-form-field">

                <label for="contact_number">
                    Contact Number
                </label>

                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number') }}"
                    placeholder="e.g. 09170000001"
                >

            </div>

            <div class="admin-health-center-form-field">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="e.g. healthcenter@ekonsulta.test"
                >

            </div>

            <div class="admin-health-center-form-field full-width">

                <label for="operating_hours">
                    Operating Hours
                </label>

                <input
                    type="text"
                    id="operating_hours"
                    name="operating_hours"
                    value="{{ old('operating_hours') }}"
                    placeholder="e.g. Monday to Friday, 8:00 AM - 5:00 PM"
                >

            </div>

        </div>

        <div class="admin-health-center-form-actions">

            <a
                href="{{ route('admin.health-centers.index') }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                Add Health Center
            </button>

        </div>

    </form>

</div>

@endsection