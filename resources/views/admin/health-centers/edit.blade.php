@extends('layouts.dashboard')

@section('title', 'Edit Health Center')

@section('page-title', 'Edit Health Center')

@section('content')

<div class="dashboard-card admin-health-center-form-page">

    <div class="card-header">

        <div>
            <h3>Edit Health Center</h3>
            <p>Update health center information</p>
        </div>

        <a href="{{ route('admin.health-centers.show', $healthCenter) }}">
            Back to Details
        </a>

    </div>

    <form
        method="POST"
        action="{{ route('admin.health-centers.update', $healthCenter) }}"
        class="admin-health-center-form"
    >

        @csrf
        @method('PUT')

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
                    value="{{ old('name', $healthCenter->name) }}"
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
                    value="{{ old('address', $healthCenter->address) }}"
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
                    value="{{ old('contact_number', $healthCenter->contact_number) }}"
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
                    value="{{ old('email', $healthCenter->email) }}"
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
                    value="{{ old('operating_hours', $healthCenter->operating_hours) }}"
                >

            </div>

        </div>

        <div class="admin-health-center-form-actions">

            <a
                href="{{ route('admin.health-centers.show', $healthCenter) }}"
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