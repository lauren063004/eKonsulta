@extends('layouts.dashboard')

@section('title', 'Add Staff')
@section('page-title', 'Add Staff')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>Add Staff</h3>
            <p>Create a new staff account for the e-Konsulta system</p>
        </div>

        <a
            href="{{ route('admin.staff.index') }}"
            class="secondary-button"
        >
            Back to Staff
        </a>

    </div>

    @if($errors->any())
        <div class="error-message">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.staff.store') }}"
    >

        @csrf

        <div class="form-group">
            <label for="name">Staff Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">
                Confirm Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >
        </div>

        <div class="form-group">
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

        <div class="form-group">
            <label for="employee_number">
                Employee Number
            </label>

            <input
                type="text"
                id="employee_number"
                name="employee_number"
                value="{{ old('employee_number') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="position">Position</label>

            <input
                type="text"
                id="position"
                name="position"
                value="{{ old('position') }}"
                placeholder="e.g. Health Center Staff"
                required
            >
        </div>

        <div class="form-group">
            <label for="contact_number">
                Contact Number
            </label>

            <input
                type="text"
                id="contact_number"
                name="contact_number"
                value="{{ old('contact_number') }}"
            >
        </div>

        <div class="form-actions">

            <a
                href="{{ route('admin.staff.index') }}"
                class="secondary-button"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="primary-button"
            >
                Create Staff
            </button>

        </div>

    </form>

</div>

@endsection