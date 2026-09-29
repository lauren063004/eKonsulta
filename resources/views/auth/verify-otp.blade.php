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

    <h1>e-Konsulta</h1>

    <h2>Verify Your Email</h2>

    <p>
        We sent a 6-digit verification code to your Gmail address.
    </p>

    <p>
        Please enter the code below to complete your registration.
    </p>

    @if (session('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('register.verify.submit') }}"
    >
        @csrf

        <div>
            <label for="otp">
                Verification Code
            </label>

            <input
                id="otp"
                type="text"
                name="otp"
                inputmode="numeric"
                maxlength="6"
                pattern="[0-9]{6}"
                autocomplete="one-time-code"
                value="{{ old('otp') }}"
                required
            >
        </div>

        <button type="submit">
            Verify Email
        </button>
    </form>

    <form
        method="POST"
        action="{{ route('register.resend-otp') }}"
    >
        @csrf

        <button type="submit">
            Resend Code
        </button>
    </form>

    <p>
        <a href="{{ route('register') }}">
            Back to Registration
        </a>
    </p>

</body>
</html>