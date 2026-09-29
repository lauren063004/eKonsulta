<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>e-Konsulta Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<main class="ek-auth">

    @include('partials.auth-brand')

    <section class="ek-auth-panel ek-auth-panel--center">

        <div class="ek-card">

            <h2>Welcome Back!</h2>
            <p class="ek-card-intro">Login to your account to continue.</p>

            @if ($errors->any())
                <div class="ek-alert" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="ek-form">
                @csrf

                <div class="ek-field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        class="ek-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="ek-field">
                    <label for="password">Password</label>
                    <div class="ek-password">
                        <input
                            id="password"
                            class="ek-input"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button
                            type="button"
                            class="ek-toggle"
                            data-toggle-password="password"
                            aria-controls="password"
                            aria-pressed="false"
                        >Show</button>
                    </div>
                </div>

                <div>
                    <label class="ek-check">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="ek-btn">
                    Login
                </button>
            </form>

            <p class="ek-foot">
                Don't have an account?
                <a href="{{ route('register') }}" class="ek-link">Register as Patient</a>
            </p>

        </div>

    </section>

</main>

<script>
    document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.dataset.togglePassword);
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.textContent = show ? 'Hide' : 'Show';
            button.setAttribute('aria-pressed', show ? 'true' : 'false');
        });
    });
</script>

</body>
</html>