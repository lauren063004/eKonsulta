<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Verify Email - e-Konsulta</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

<div class="ek-auth">

    {{-- Brand panel --}}
    <aside class="ek-auth-brand">

        <div class="ek-brand-content">

            {{-- Placeholder seal. Swap for: <img class="ek-seal" src="{{ asset('images/cho-seal.png') }}" alt="Taguig City Health Office seal"> --}}
            <svg class="ek-seal" viewBox="0 0 96 96" aria-hidden="true">
                <circle cx="48" cy="48" r="45" fill="#fff" stroke="#0A3D8F" stroke-width="5"/>
                <path fill="#D91E25" d="M41 24h14v17h17v14H55v17H41V55H24V41h17z"/>
            </svg>

            <h1 class="ek-wordmark">
                <span>e-<span class="ek-wordmark-red" style="display:inline;">Konsulta</span></span>
            </h1>

            <p class="ek-brand-sub">
                City Health System — online consultation booking and
                digital health records for Taguig residents.
            </p>

            <p class="ek-tagline">
                <span>Mabilis. Maayos.</span>
                <span>Malapit sa iyo.</span>
            </p>

        </div>

    </aside>


    {{-- Form panel --}}
    <main class="ek-auth-panel ek-auth-panel--center">

        <div class="ek-card">

            <h2>Verify Your Email</h2>

            <p class="ek-card-intro">
                We sent a 6-digit verification code to your Gmail address.
                Please enter the code below to complete your registration.
            </p>

            @if (session('success'))
                <div class="ek-alert ek-alert--success" role="status">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="ek-alert" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('register.verify.submit') }}"
                class="ek-form"
            >
                @csrf

                <div class="ek-field">
                    <label for="otp">
                        Verification Code
                    </label>

                    <input
                        id="otp"
                        class="ek-input ek-input--otp"
                        type="text"
                        name="otp"
                        inputmode="numeric"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        autocomplete="one-time-code"
                        placeholder="••••••"
                        value="{{ old('otp') }}"
                        required
                        autofocus
                    >
                </div>

                <button type="submit" class="ek-btn">
                    Verify Email
                </button>
            </form>

            <form
                method="POST"
                action="{{ route('register.resend-otp') }}"
                class="ek-form"
                style="margin-top: 12px;"
            >
                @csrf

                <button type="submit" class="ek-btn ek-btn--ghost">
                    Resend Code
                </button>
            </form>

            <p class="ek-foot">
                <a href="{{ route('register') }}" class="ek-link">
                    ← Back to Registration
                </a>
            </p>

        </div>

    </main>

</div>

</body>
</html>