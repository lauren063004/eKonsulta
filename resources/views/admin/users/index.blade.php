@extends('layouts.dashboard')

@section('title', 'User Management')

@section('page-title', 'User Management')

@section('content')

```
<section class="dashboard-card">

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

        <div class="medical-records-list">

            @foreach($users as $user)

                <div class="appointment-preview">

                    <div class="appointment-date">

                        <strong>
                            {{ strtoupper(substr($user->role, 0, 1)) }}
                        </strong>

                        <span>
                            {{ ucfirst($user->role) }}
                        </span>

                    </div>

                    <div class="appointment-details">

                        <h4>
                            {{ $user->name }}
                        </h4>

                        <p>
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </p>

                        <p>
                            <strong>Role:</strong>
                            {{ ucfirst($user->role) }}
                        </p>

                        <a
                            href="{{ route('admin.users.show', $user) }}"
                            class="primary-button"
                        >
                            View Details
                        </a>

                    </div>

                </div>

                <hr>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                👥
            </div>

            <h4>No users found</h4>

            <p>
                There are currently no registered users in the system.
            </p>

        </div>

    @endif

</section>
```

@endsection
