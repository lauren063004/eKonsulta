@extends('layouts.dashboard')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
    <div class="dashboard-card staff-profile-page">
        <div class="staff-profile-header">
            <div class="staff-profile-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
            <div class="staff-profile-information">
                <h3>{{ $user->name }}</h3>
                <span class="staff-profile-label">Doctor</span>
            </div>
        </div>

        <section class="staff-profile-section">
            <div class="staff-profile-section-heading">
                <div>
                    <span class="staff-profile-section-label">Account</span>
                    <h4>Profile Information</h4>
                </div>
            </div>
            <div class="staff-profile-information-grid">
                <div class="staff-profile-info-item">
                    <span>Full name</span>
                    <strong>{{ $user->name }}</strong>
                </div>
                <div class="staff-profile-info-item">
                    <span>Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>
                <div class="staff-profile-info-item">
                    <span>Role</span>
                    <strong>Doctor</strong>
                </div>
                <div class="staff-profile-info-item">
                    <span>Health Center</span>
                    <strong>{{ $doctor->healthCenter?->name ?? 'Not assigned' }}</strong>
                </div>
            </div>
        </section>
    </div>
@endsection
