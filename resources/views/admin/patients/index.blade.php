@extends('layouts.dashboard')

@section('title', 'Patients')

@section('content')
    <div class="admin-patient-page">
        <header class="admin-patient-page__header">
            <div>
                <p class="admin-patient-page__eyebrow">Admin directory</p>
                <h1>Patients</h1>
                <p>Search patient accounts using a name, email, or patient number.</p>
            </div>
        </header>

        <section class="admin-patient-panel" aria-labelledby="patient-directory-heading">
            <h2 id="patient-directory-heading" class="sr-only">Patient directory</h2>

            <form method="GET" action="{{ route('admin.patients.index') }}" class="admin-patient-search">
                <label for="patient-search">Search patients</label>
                <div class="admin-patient-search__controls">
                    <input
                        id="patient-search"
                        name="search"
                        type="search"
                        value="{{ $search }}"
                        maxlength="100"
                        placeholder="Name, email, or patient number"
                    >
                    <button type="submit" class="primary-button">Search</button>
                    @if ($search !== '')
                        <a href="{{ route('admin.patients.index') }}" class="secondary-button">Clear</a>
                    @endif
                </div>
            </form>

            @if ($patients->count())
                <div class="admin-patient-table-wrap">
                    <table class="admin-patient-table">
                        <thead>
                            <tr>
                                <th scope="col">Patient</th>
                                <th scope="col">Email</th>
                                <th scope="col">Account status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <th scope="row">
                                        <span class="admin-patient-table__name">{{ $patient->user->name }}</span>
                                        <span class="admin-patient-table__number">{{ $patient->patient_number }}</span>
                                    </th>
                                    <td>{{ $patient->user->email }}</td>
                                    <td>
                                        <span class="admin-patient-status admin-patient-status--{{ $patient->user->status }}">
                                            {{ ucfirst($patient->user->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <nav class="admin-patient-pagination" aria-label="Patient list pages">
                    {{ $patients->links() }}
                </nav>
            @else
                <div class="admin-patient-empty" role="status">
                    <h2>No patients found</h2>
                    <p>
                        {{ $search !== ''
                            ? 'Try another name, email, or patient number.'
                            : 'Patient accounts will appear here when they are registered.' }}
                    </p>
                </div>
            @endif
        </section>
    </div>
@endsection
