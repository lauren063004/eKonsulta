<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>e-Konsulta Registration</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <h1>e-Konsulta</h1>

    <h2>Patient Registration</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div>
            <label>Full Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
        </div>

        <div>
            <label>Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
            >
        </div>

        <div>
            <label>Date of Birth</label>
            <input
                type="date"
                name="date_of_birth"
                value="{{ old('date_of_birth') }}"
                required
            >
        </div>

        <div>
            <label>Sex</label>

            <select name="sex" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div>
            <label>Contact Number</label>
            <input
                type="text"
                name="contact_number"
                value="{{ old('contact_number') }}"
                required
            >
        </div>

        <div>
            <label>Address</label>
            <textarea
                name="address"
                required
            >{{ old('address') }}</textarea>
        </div>

        <div>
            <label>Emergency Contact Name</label>
            <input
                type="text"
                name="emergency_contact_name"
                value="{{ old('emergency_contact_name') }}"
                required
            >
        </div>

        <div>
            <label>Emergency Contact Number</label>
            <input
                type="text"
                name="emergency_contact_number"
                value="{{ old('emergency_contact_number') }}"
                required
            >
        </div>

        <button type="submit">
            Register
        </button>
    </form>

    <p>
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </p>

</body>
</html>