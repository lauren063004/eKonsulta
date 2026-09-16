@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('content')

<div class="dashboard-card staff-profile-page">

    {{-- PROFILE HEADER --}}

    <div class="card-header">

        <div>
            <h3>My Profile</h3>
            <p>Staff account and employment information</p>
        </div>

        <a href="{{ route('staff.dashboard') }}">
            Back to Dashboard
        </a>

    </div>


    {{-- STAFF PROFILE --}}

    <div class="staff-profile-header">

        <div class="staff-profile-avatar">
            &#128100;
        </div>

        <div class="staff-profile-information">

            <span class="staff-profile-label">
                STAFF PROFILE
            </span>

            <h2>
                {{ $staff->user->name ?? 'Staff Member' }}
            </h2>

            <p>
                {{ $staff->position ?? 'Health Center Staff' }}
            </p>

        </div>

    </div>


    {{-- ACCOUNT INFORMATION --}}

    <section class="staff-profile-section">

        <div class="staff-profile-section-heading">

            <div>
                <span class="staff-profile-section-label">
                    ACCOUNT INFORMATION
                </span>

                <h3>Personal Information</h3>

                <p>
                    Basic account information associated with your staff account.
                </p>
            </div>

        </div>


        <div class="staff-profile-information-grid">

            <div class="staff-profile-info-item">

                <span>FULL NAME</span>

                <strong>
                    {{ $staff->user->name ?? 'Not available' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>EMAIL ADDRESS</span>

                <strong>
                    {{ $staff->user->email ?? 'Not available' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>CONTACT NUMBER</span>

                <strong>
                    {{ $staff->contact_number ?? 'Not available' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>ROLE</span>

                <strong>
                    Staff
                </strong>

            </div>

        </div>

    </section>


    {{-- EMPLOYMENT INFORMATION --}}

    <section class="staff-profile-section">

        <div class="staff-profile-section-heading">

            <div>
                <span class="staff-profile-section-label">
                    EMPLOYMENT INFORMATION
                </span>

                <h3>Staff Assignment</h3>

                <p>
                    Employment and health center assignment details.
                </p>
            </div>

        </div>


        <div class="staff-profile-information-grid">

            <div class="staff-profile-info-item">

                <span>EMPLOYEE NUMBER</span>

                <strong>
                    {{ $staff->employee_number ?? 'Not available' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>POSITION</span>

                <strong>
                    {{ $staff->position ?? 'Health Center Staff' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>ASSIGNED HEALTH CENTER</span>

                <strong>
                    {{ $staff->healthCenter->name ?? 'Not assigned' }}
                </strong>

            </div>


            <div class="staff-profile-info-item">

                <span>ACCOUNT STATUS</span>

                <strong class="staff-profile-status">
                    Active
                </strong>

            </div>

        </div>

    </section>


    {{-- BACK BUTTON --}}

    <div class="staff-profile-footer">

        <a
            href="{{ route('staff.dashboard') }}"
            class="primary-button"
        >
            Back to Dashboard
        </a>

    </div>

</div>

@endsection