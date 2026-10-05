<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="--ek-hero-image: url('{{ asset('images/hero-bg.jpg') }}'); --ek-wave-banner: url('{{ asset('images/wave-banner.jpg') }}');">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | e-Konsulta</title>
    <link rel="icon" href="{{ asset('images/cross-badge.jpg') }}">
   @vite('resources/js/app.js')
</head>
<body>

<main class="auth-page">

    {{-- Left: hero --}}
    <section class="auth-hero" aria-label="About e-Konsulta">

        <div class="auth-hero-brand">
            <img
                src="{{ asset('images/cho-seal.jpg') }}"
                alt="City Health Office of Taguig seal"
            >
            <div>
                <strong>e-Konsulta</strong>
                <span>City Health Office &bull; City of Taguig</span>
            </div>
        </div>

        <h2>Quality healthcare, <em>closer</em> to every family.</h2>

        <p>
            Book consultations at your barangay health center, view your
            prescriptions, and keep your medical records in one secure place.
        </p>

    </section>


    {{-- Right: form --}}
    <section class="auth-panel">

        <div class="auth-card">

            <img
                class="auth-card-logo"
                src="{{ asset('images/cho-seal.jpg') }}"
                alt="City Health Office of Taguig seal"
            >

            <h1>Welcome back</h1>
            <p>Sign in to your e-Konsulta account.</p>

            @if (session('status'))
                <div class="alert alert-success" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>We couldn't sign you in:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="auth-row">
                    <label class="auth-check">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="primary-button">
                    Sign In
                </button>

            </form>

            @if (Route::has('register'))
                <p class="auth-switch">
                    New patient?
                    <a href="{{ route('register') }}">Create an account</a>
                </p>
            @endif

            <p class="auth-foot">
                &copy; {{ date('Y') }} City Health Office of Taguig. All rights reserved.
            </p>

        </div>

    </section>

</main>

</body>
</html>