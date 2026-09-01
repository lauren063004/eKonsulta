@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('page-title', 'Administration Dashboard')

@section('content')

    <section class="welcome-banner">

        <div>
            <span class="welcome-label">
                e-Konsulta Administration
            </span>

            <h1>
                Good day, {{ auth()->user()->name }}!
            </h1>

            <p>
                Monitor the city health system and manage
                users, health centers, and system activities.
            </p>
        </div>

        <div class="welcome-icon">
            ⚙️
        </div>

    </section>


    <section class="stats-grid">

        <x-stat-card
            icon="👥"
            label="Total Patients"
            value="0"
        />

        <x-stat-card
            icon="🩺"
            label="Doctors"
            value="0"
        />

        <x-stat-card
            icon="🏥"
            label="Health Centers"
            value="0"
        />

        <x-stat-card
            icon="📅"
            label="Appointments"
            value="0"
        />

    </section>


    <div class="dashboard-grid">

        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>System Overview</h3>
                    <p>e-Konsulta activity</p>
                </div>

                <a href="#">
                    Reports
                </a>

            </div>

            <div class="empty-state">

                <div class="empty-icon">
                    📊
                </div>

                <h4>Dashboard analytics</h4>

                <p>
                    System statistics and reports will appear here
                    once transactions are recorded.
                </p>

            </div>

        </section>


        <section class="dashboard-card">

            <div class="card-header">

                <div>
                    <h3>Administration</h3>
                    <p>System management</p>
                </div>

            </div>

            <div class="quick-actions">

              <a href="{{ route('admin.users.index') }}" class="quick-action">
    <span>👥</span>
    <strong>User Management</strong>
    <small>Manage system users</small>
</a>

              <a href="{{ route('admin.health-centers.index') }}" class="quick-action">
    <span>🏥</span>
    <strong>Health Centers</strong>
    <small>Manage health centers</small>
</a>

                <a href="#" class="quick-action">
                    <span>📊</span>
                    <strong>Reports</strong>
                    <small>View system reports</small>
                </a>

                <a href="#" class="quick-action">
                    <span>📋</span>
                    <strong>Activity Logs</strong>
                    <small>Monitor system activity</small>
                </a>

            </div>

        </section>

    </div>

@endsection