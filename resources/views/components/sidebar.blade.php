<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">

        <div class="brand-icon">
            🏥
        </div>

        <div>
            <h1>e-Konsulta</h1>
            <span>City Health System</span>
        </div>

    </div>

    <nav class="sidebar-navigation">

        {{-- ============================= --}}
        {{-- PATIENT NAVIGATION --}}
        {{-- ============================= --}}

        @if(auth()->user()->isPatient())

            <div class="nav-section">
                <span>MAIN</span>
            </div>

            <a
                href="{{ route('patient.dashboard') }}"
                class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"
            >
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('patient.appointments.index') }}"
                class="nav-link {{ request()->routeIs('patient.appointments.*') ? 'active' : '' }}"
            >
                <span>📅</span>
                <span>Appointments</span>
            </a>

            <a
                href="{{ route('patient.prescriptions.index') }}"
                class="nav-link {{ request()->routeIs('patient.prescriptions.*') ? 'active' : '' }}"
            >
                <span>💊</span>
                <span>Prescriptions</span>
            </a>

            <a
                href="{{ route('patient.medical-records.index') }}"
                class="nav-link {{ request()->routeIs('patient.medical-records.*') ? 'active' : '' }}"
            >
                <span>📋</span>
                <span>Medical Records</span>
            </a>

            <div class="nav-section">
                <span>ACCOUNT</span>
            </div>

            <a href="#" class="nav-link">
                <span>👤</span>
                <span>My Profile</span>
            </a>

            <a href="#" class="nav-link">
                <span>🔔</span>
                <span>Notifications</span>
            </a>

        @endif


        {{-- ============================= --}}
        {{-- DOCTOR NAVIGATION --}}
        {{-- ============================= --}}

        @if(auth()->user()->isDoctor())

            <div class="nav-section">
                <span>MAIN</span>
            </div>

            <a
                href="{{ route('doctor.dashboard') }}"
                class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"
            >
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('doctor.appointments.index') }}"
                class="nav-link {{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}"
            >
                <span>📅</span>
                <span>Appointments</span>
            </a>

            <a
                href="{{ route('doctor.consultations.index') }}"
                class="nav-link {{ request()->routeIs('doctor.consultations.*') ? 'active' : '' }}"
            >
                <span>🩺</span>
                <span>Consultations</span>
            </a>

            <a
                href="{{ route('doctor.patients.index') }}"
                class="nav-link {{ request()->routeIs('doctor.patients.*') ? 'active' : '' }}"
            >
                <span>👥</span>
                <span>Patients</span>
            </a>

            <a
                href="{{ route('doctor.prescriptions.index') }}"
                class="nav-link {{ request()->routeIs('doctor.prescriptions.*') ? 'active' : '' }}"
            >
                <span>💊</span>
                <span>Prescriptions</span>
            </a>

        @endif


        {{-- ============================= --}}
        {{-- STAFF NAVIGATION --}}
        {{-- ============================= --}}

        @if(auth()->user()->isStaff())

            <div class="nav-section">
                <span>MAIN</span>
            </div>

            <a
                href="{{ route('staff.dashboard') }}"
                class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
            >
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('staff.profile') }}"
                class="nav-link {{ request()->routeIs('staff.profile') ? 'active' : '' }}"
            >
                <span>👤</span>
                <span>My Profile</span>
            </a>

            <a
                href="{{ route('staff.patients.index') }}"
                class="nav-link {{ request()->routeIs('staff.patients.*') ? 'active' : '' }}"
            >
                <span>👥</span>
                <span>Patients</span>
            </a>
<a
    href="{{ route('staff.appointment-schedules.index') }}"
    class="nav-link {{ request()->routeIs('staff.appointment-schedules.*') ? 'active' : '' }}"
>
    <span>📅</span>
    <span>Appointment Schedules</span>
</a>
            <a
                href="{{ route('staff.consultations.index') }}"
                class="nav-link {{ request()->routeIs('staff.consultations.*') ? 'active' : '' }}"
            >
                <span>🩺</span>
                <span>Consultations</span>
            </a>

            <a
                href="{{ route('staff.health-centers.index') }}"
                class="nav-link {{ request()->routeIs('staff.health-centers.*') ? 'active' : '' }}"
            >
                <span>🏥</span>
                <span>Health Centers</span>
            </a>

            <a
                href="{{ route('staff.prescriptions.index') }}"
                class="nav-link {{ request()->routeIs('staff.prescriptions.*') ? 'active' : '' }}"
            >
                <span>💊</span>
                <span>Prescriptions</span>
            </a>

        @endif


        {{-- ============================= --}}
        {{-- ADMIN NAVIGATION --}}
        {{-- ============================= --}}

        @if(auth()->user()->isAdmin())

            <div class="nav-section">
                <span>ADMINISTRATION</span>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
            >
                <span>👥</span>
                <span>Users</span>
            </a>

            <a
                href="{{ route('admin.health-centers.index') }}"
                class="nav-link {{ request()->routeIs('admin.health-centers.*') ? 'active' : '' }}"
            >
                <span>🏥</span>
                <span>Health Centers</span>
            </a>

            <a
    href="{{ route('admin.doctors.index') }}"
    class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
>
    <span>🩺</span>
    <span>Doctors</span>
</a>

            <a href="#" class="nav-link">
                <span>📊</span>
                <span>Reports</span>
            </a>

          <a
    href="{{ route('admin.activity-logs.index') }}"
    class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"
>
    <span>📋</span>
    <span>Activity Logs</span>
</a>

        @endif

    </nav>


    {{-- ============================= --}}
    {{-- BOTTOM SIDEBAR --}}
    {{-- ============================= --}}

    <div class="sidebar-bottom">

        <div class="system-status">
            <span class="status-dot"></span>
            <span>System Online</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="logout-button"
            >
                <span>🚪</span>
                <span>Logout</span>
            </button>

        </form>

    </div>

</aside>