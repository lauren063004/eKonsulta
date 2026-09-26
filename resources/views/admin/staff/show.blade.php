@extends('layouts.dashboard')

@section('title', 'Staff Details')

@section('page-title', 'Staff Details')

@section('content')

<div class="dashboard-card">

    <div class="card-header">
        <div>
            <h3>Staff Details</h3>
            <p>View staff account and professional information</p>
        </div>

        <a href="{{ route('admin.staff.index') }}">
            Back to Staff
        </a>

        <a href="{{ route('admin.staff.edit', $staff) }}">
            Edit Staff
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-user-card">

        <div class="admin-user-avatar">
            👤
        </div>

        <div class="admin-user-information">

            <span class="admin-user-label">
                STAFF
            </span>

            <h4>{{ $staff->user->name }}</h4>

            <div class="admin-user-meta">

                <span>
                    <strong>Status:</strong>
                    {{ ucfirst($staff->user->status) }}
                </span>

                <span>
                    <strong>Email Address:</strong>
                    {{ $staff->user->email }}
                </span>

                <span>
                    <strong>Employee Number:</strong>
                    {{ $staff->employee_number }}
                </span>

                <span>
                    <strong>Position:</strong>
                    {{ $staff->position }}
                </span>

                <span>
                    <strong>Contact Number:</strong>
                    {{ $staff->contact_number ?? 'N/A' }}
                </span>

                <span>
                    <strong>Health Center:</strong>
                    {{ $staff->healthCenter->name }}
                </span>

                <span>
                    <strong>Account Created:</strong>
                    {{ $staff->user->created_at->format('F d, Y') }}
                </span>

            </div>

        </div>

    </div>

    <div style="margin-top: 20px;">

        <a
            href="{{ route('admin.staff.index') }}"
            class="primary-button"
        >
            Back to Staff List
        </a>

        @if($staff->user->id !== auth()->id())

            <form
                method="POST"
                action="{{ route('admin.staff.toggle-status', $staff) }}"
                style="display: inline;"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="status-button {{ $staff->user->status === 'active' ? 'deactivate' : 'activate' }}"
                >
                    {{ $staff->user->status === 'active'
                        ? 'Deactivate Staff'
                        : 'Activate Staff'
                    }}
                </button>

            </form>

        @endif

    </div>

</div>

@endsection