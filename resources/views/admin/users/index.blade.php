@extends('layouts.dashboard')

@section('title', 'User Management')

@section('page-title', 'User Management')

@section('content')

<div class="dashboard-card">

    <div class="card-header">

        <div>
            <h3>All Users</h3>
            <p>Manage registered e-Konsulta system users</p>
        </div>

        <a href="{{ route('admin.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($users->count())

        <div class="admin-user-list">

            @foreach($users as $user)

                <div class="admin-user-card">

                    <div class="admin-user-avatar">
                        &#128100;
                    </div>

                    <div class="admin-user-information">

                        <span class="admin-user-label">
                            {{ strtoupper($user->role) }}
                        </span>

                        <h4>
                            {{ $user->name }}
                        </h4>

                        <div class="admin-user-meta">

                            <span>
                                <strong>Email:</strong>
                                {{ $user->email }}
                            </span>

                            <span>
                                <strong>Role:</strong>
                                {{ ucfirst($user->role) }}
                            </span>

                        </div>

                    </div>

                    <div class="admin-user-action">

                        <a
                            href="{{ route('admin.users.show', $user) }}"
                            class="primary-button"
                        >
                            View Details
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                &#128100;
            </div>

            <h4>No users found</h4>

            <p>
                There are currently no registered users in the system.
            </p>

        </div>

    @endif

</div>

@endsection