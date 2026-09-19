@extends('layouts.dashboard')

@section('title', 'Health Centers')

@section('page-title', 'Health Centers')

@section('content')

<div class="dashboard-card admin-health-centers-page">

    <div class="card-header">

        <div>
            <h3>Health Centers</h3>
            <p>Manage registered health centers and their information</p>
        </div>

        <a href="{{ route('admin.dashboard') }}">
            Back to Dashboard
        </a>

    </div>

    @if($healthCenters->count())

        <div class="admin-health-center-list">

            @foreach($healthCenters as $healthCenter)

                <div class="admin-health-center-card">

                    <div class="admin-health-center-header">

                        <div class="admin-health-center-icon">
                            &#127973;
                        </div>

                        <div class="admin-health-center-title">

                            <span class="admin-health-center-label">
                                HEALTH CENTER
                            </span>

                            <h4>
                                {{ $healthCenter->name }}
                            </h4>

                            @if($healthCenter->address)
                                <p>
                                    {{ $healthCenter->address }}
                                </p>
                            @endif

                        </div>

                        <div class="admin-health-center-status">

                            <span class="status-badge {{ $healthCenter->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ ucfirst($healthCenter->status) }}
                            </span>

                        </div>

                    </div>


                    <div class="admin-health-center-information">

                        @if($healthCenter->contact_number)
                            <div>
                                <span>CONTACT</span>
                                <strong>
                                    {{ $healthCenter->contact_number }}
                                </strong>
                            </div>
                        @endif

                        @if($healthCenter->email)
                            <div>
                                <span>EMAIL</span>
                                <strong>
                                    {{ $healthCenter->email }}
                                </strong>
                            </div>
                        @endif

                        <div>
                            <span>DOCTORS</span>
                            <strong>
                                {{ $healthCenter->doctors->count() }}
                            </strong>
                        </div>

                        <div>
                            <span>STAFF</span>
                            <strong>
                                {{ $healthCenter->staff->count() }}
                            </strong>
                        </div>

                    </div>


                 <div class="admin-health-center-footer">

    <a
        href="{{ route('admin.health-centers.show', $healthCenter) }}"
        class="primary-button"
    >
        View Details
    </a>

    <form
        method="POST"
        action="{{ route('admin.health-centers.toggle-status', $healthCenter) }}"
        class="admin-health-center-status-form"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="status-button {{ $healthCenter->status === 'active' ? 'deactivate' : 'activate' }}"
        >
            {{ $healthCenter->status === 'active' ? 'Deactivate' : 'Activate' }}
        </button>
    </form>

</div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                &#127973;
            </div>

            <h4>No health centers found</h4>

            <p>
                There are currently no registered health centers.
            </p>

        </div>

    @endif

</div>

@endsection