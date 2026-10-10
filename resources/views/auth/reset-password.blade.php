<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="--ek-hero-image: url('{{ asset('images/hero-bg.jpg') }}'); --ek-wave-banner: url('{{ asset('images/wave-banner.jpg') }}');">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | e-Konsulta</title>
    <link rel="icon" href="{{ asset('images/cross-badge.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body>

<main class="auth-page">
    <section class="auth-hero" aria-label="About e-Konsulta">
        <div class="auth-hero-brand">
            <img src="{{ asset('images/cho-seal.jpg') }}" alt="City Health Office of Taguig seal">
            <div>
                <strong>e-Konsulta</strong>
                <span>City Health Office &bull; City of Taguig</span>
            </div>
        </div>

        <h2>Set a new <em>password</em>.</h2>
        <p>Choose a strong password to keep your e-Konsulta account protected.</p>
    </section>

    <section class="auth-panel">
        <div class="auth-card">
            <img
                class="auth-card-logo"
                src="{{ asset('images/cho-seal.jpg') }}"
                alt="City Health Office of Taguig seal"
            >

            <h1>Reset your password</h1>
            <p>Create a new password that you haven’t used for this account before.</p>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" data-password-reset-form>
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="auth-field">
                    <label for="password">New password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        data-password-rule-input
                        aria-describedby="password-requirements"
                        required
                    >
                </div>

                <ul class="password-requirements" id="password-requirements" aria-label="Password requirements">
                    <li data-password-rule="length"><span aria-hidden="true"></span>At least 8 characters</li>
                    <li data-password-rule="uppercase"><span aria-hidden="true"></span>At least one uppercase letter</li>
                    <li data-password-rule="lowercase"><span aria-hidden="true"></span>At least one lowercase letter</li>
                    <li data-password-rule="number"><span aria-hidden="true"></span>At least one number</li>
                </ul>

                <div class="auth-field">
                    <label for="password_confirmation">Confirm new password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        data-password-confirmation
                        aria-describedby="password-match-status"
                        required
                    >
                    <small class="password-match-status" id="password-match-status" data-password-match-status>
                        Re-enter your new password to confirm it.
                    </small>
                </div>

                <button type="submit" class="primary-button">
                    Save new password
                </button>
            </form>

            <p class="auth-switch">
                <a href="{{ route('login') }}">Back to sign in</a>
            </p>

            <p class="auth-foot">
                &copy; {{ date('Y') }} City Health Office of Taguig. All rights reserved.
            </p>
        </div>
    </section>
</main>

</body>
</html>
