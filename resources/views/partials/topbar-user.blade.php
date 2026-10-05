@php
$authUser = auth()->user();

$roleLabel = 'User';

if ($authUser->isPatient()) {
    $roleLabel = 'Patient';
} elseif ($authUser->isDoctor()) {
    $roleLabel = 'Doctor';
} elseif ($authUser->isStaff()) {
    $roleLabel = 'Health Center Staff';
} elseif ($authUser->isAdmin()) {
    $roleLabel = 'Administrator';
}

$initial = strtoupper(
    mb_substr($authUser->name, 0, 1)
);

$unreadCount = isset($notificationCount)
    ? (int) $notificationCount
    : 0;

@endphp

<div class="topbar-actions">

{{-- =========================================================
     NOTIFICATIONS
     ========================================================= --}}

<div class="dropdown" data-dropdown>

    <button
        type="button"
        class="icon-button"
        data-dropdown-toggle
        aria-haspopup="true"
        aria-expanded="false"
        aria-label="Notifications"
    >

        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 8 3 8H3s3-1 3-8"/>
            <path d="M10.3 20a2 2 0 0 0 3.4 0"/>
        </svg>

        @if ($unreadCount > 0)
            <span class="badge-dot">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif

    </button>


    <div
        class="dropdown-menu dropdown-menu--wide"
        role="menu"
    >

        <div class="notif-head">

            <strong>
                Notifications
            </strong>

            <span>
                {{ $unreadCount }} unread
            </span>

        </div>


        @if ($unreadCount > 0)

            <div class="notif-empty">

                <div class="empty-icon">
                    🔔
                </div>

                <strong>
                    You have notifications
                </strong>

                <span>
                    Appointment updates and reminders
                    will appear here.
                </span>

            </div>

        @else

            <div class="notif-empty">

                <div class="empty-icon">
                    🔔
                </div>

                <strong>
                    You're all caught up
                </strong>

                <span>
                    Appointment updates and reminders
                    will appear here.
                </span>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     USER DROPDOWN
     ========================================================= --}}

<div class="dropdown user-dropdown-wrapper" data-dropdown>

    <button
        type="button"
        class="user-button"
        data-dropdown-toggle
        aria-haspopup="true"
        aria-expanded="false"
    >

        <span
            class="user-avatar"
            aria-hidden="true"
        >
            {{ $initial }}
        </span>


        <span class="user-info">

            <strong>
                {{ $authUser->name }}
            </strong>

            <span>
                {{ $roleLabel }}
            </span>

        </span>


        <svg
            class="user-caret"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="m6 9 6 6 6-6"/>
        </svg>

    </button>


    {{-- =====================================================
         USER DROPDOWN MENU
         ===================================================== --}}

    <div
        class="dropdown-menu user-dropdown-menu"
        role="menu"
    >

        <div class="dropdown-head">

            <span
                class="user-avatar user-avatar--lg"
                aria-hidden="true"
            >
                {{ $initial }}
            </span>


            <div>

                <strong>
                    {{ $authUser->name }}
                </strong>

                <small>
                    {{ $authUser->email }}
                </small>

                <span class="role-chip">
                    {{ $roleLabel }}
                </span>

            </div>

        </div>


        <div class="dropdown-divider"></div>


        {{-- My Profile --}}

        @if ($authUser->isPatient())

            <a
                href="{{ route('patient.profile') }}"
                class="dropdown-item"
                role="menuitem"
            >
                <span>👤</span>
                <span>My Profile</span>
            </a>

        @elseif ($authUser->isDoctor())

            <a
                href="{{ route('doctor.dashboard') }}"
                class="dropdown-item"
                role="menuitem"
            >
                <span>👤</span>
                <span>My Profile</span>
            </a>

        @elseif ($authUser->isStaff())

            <a
                href="{{ route('staff.profile') }}"
                class="dropdown-item"
                role="menuitem"
            >
                <span>👤</span>
                <span>My Profile</span>
            </a>

        @endif


        <div class="dropdown-divider"></div>


        {{-- =================================================
             LOGOUT
             ================================================= --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="dropdown-item dropdown-item--danger"
                role="menuitem"
            >

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="m16 17 5-5-5-5"/>
                    <path d="M21 12H9"/>
                </svg>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>
</div>

{{-- =============================================================
DROPDOWN JAVASCRIPT
============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const dropdowns = document.querySelectorAll('[data-dropdown]');


    dropdowns.forEach(function (dropdown) {

        const button = dropdown.querySelector('[data-dropdown-toggle]');
        const menu = dropdown.querySelector('.dropdown-menu');


        if (!button || !menu) {
            return;
        }


        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();


            // Close every other dropdown
            dropdowns.forEach(function (otherDropdown) {

                if (otherDropdown !== dropdown) {

                    otherDropdown.classList.remove('is-open');


                    const otherButton =
                        otherDropdown.querySelector('[data-dropdown-toggle]');


                    if (otherButton) {

                        otherButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }

            });


            // Toggle current dropdown
            const isOpen =
                dropdown.classList.toggle('is-open');


            button.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

        });

    });


    // =========================================================
    // CLOSE WHEN CLICKING OUTSIDE
    // =========================================================

    document.addEventListener('click', function (event) {

        if (!event.target.closest('[data-dropdown]')) {

            dropdowns.forEach(function (dropdown) {

                dropdown.classList.remove('is-open');


                const button =
                    dropdown.querySelector('[data-dropdown-toggle]');


                if (button) {

                    button.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            });

        }

    });


    // =========================================================
    // CLOSE WITH ESCAPE
    // =========================================================

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            dropdowns.forEach(function (dropdown) {

                dropdown.classList.remove('is-open');


                const button =
                    dropdown.querySelector('[data-dropdown-toggle]');


                if (button) {

                    button.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            });

        }

    });

});
</script>
