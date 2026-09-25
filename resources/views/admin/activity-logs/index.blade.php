@extends('layouts.dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>Activity Logs</h1>
        <p>View important actions performed by users in the system.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>System Activity</h2>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date & Time</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($activityLogs as $log)
                    <tr>
                        <td>
                            {{ $log->user?->name ?? 'Unknown User' }}
                        </td>

                        <td>
                            {{ ucfirst($log->user?->role ?? 'Unknown') }}
                        </td>

                        <td>
                            <strong>{{ $log->action }}</strong>
                        </td>

                        <td>
                            {{ $log->description }}
                        </td>

                        <td>
                            {{ $log->ip_address ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $log->created_at->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection