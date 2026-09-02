<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Dashboard') - e-Konsulta
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dashboard-body">

    <div class="dashboard-wrapper">

        {{-- Mobile Overlay --}}
        <div
            class="sidebar-overlay"
            id="sidebarOverlay"
            onclick="toggleSidebar()"
        ></div>

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Area --}}
        <div class="main-content">

            {{-- Top Navigation --}}
           <header class="topbar">

    <button
        class="mobile-menu-button"
        onclick="toggleSidebar()"
        type="button"
    >
        ☰
    </button>

    <div class="topbar-title">
        <h2>
            @yield('page-title', 'Dashboard')
        </h2>

        <p>
            Welcome back, {{ auth()->user()->name }}
        </p>
    </div>

    <div class="topbar-user">

        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="user-info">
            <strong>
                {{ auth()->user()->name }}
            </strong>

            <span>
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

    </div>

</header>

            {{-- Page Content --}}
            <main class="page-content">

                @yield('content')

            </main>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            document
                .getElementById('sidebar')
                .classList.toggle('sidebar-open');

            document
                .getElementById('sidebarOverlay')
                .classList.toggle('overlay-visible');
        }
    </script>

</body>
</html>