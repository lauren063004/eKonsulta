<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>e-Konsulta Registration</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<main class="ek-auth">

    @include('partials.auth-brand')

    <section class="ek-auth-panel">

        <div class="ek-card ek-card--wide">

            <h2>Patient Registration</h2>
            <p class="ek-card-intro">Create your account to book appointments and view your health records.</p>

            @if ($errors->any())
                <div class="ek-alert" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="ek-grid">
                @csrf

                <h3 class="ek-section-title">Account details</h3>

                <div class="ek-field ek-field--full">
                    <label for="name">Full Name</label>
                    <input
                        id="name"
                        class="ek-input"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="ek-field ek-field--full">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        class="ek-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
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
                            autocomplete="new-password"
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

                <div class="ek-field">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="ek-password">
                        <input
                            id="password_confirmation"
                            class="ek-input"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            required
                        >
                        <button
                            type="button"
                            class="ek-toggle"
                            data-toggle-password="password_confirmation"
                            aria-controls="password_confirmation"
                            aria-pressed="false"
                        >Show</button>
                    </div>
                </div>

                <h3 class="ek-section-title">Personal information</h3>

                <div class="ek-field">
                    <label for="date_of_birth">Date of Birth</label>
                    <input
                        id="date_of_birth"
                        class="ek-input"
                        type="date"
                        name="date_of_birth"
                        value="{{ old('date_of_birth') }}"
                        autocomplete="bday"
                        required
                    >
                </div>

                <div class="ek-field">
                    <label for="sex">Sex</label>
                    <select id="sex" class="ek-input" name="sex" required>
                        <option value="">Select</option>
                        <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('sex') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="ek-field ek-field--full">
                    <label for="contact_number">Contact Number</label>
                    <input
                        id="contact_number"
                        class="ek-input"
                        type="tel"
                        name="contact_number"
                        value="{{ old('contact_number') }}"
                        autocomplete="tel"
                        required
                    >
                </div>

                <h3 class="ek-section-title">Address and health center</h3>

        <div class="ek-field">
    <label for="barangay">Barangay</label>

    <select
        id="barangay"
        name="barangay"
        class="ek-input"
        required
    >
        <option value="" disabled {{ old('barangay') ? '' : 'selected' }}>
            Select your Barangay
        </option>

        @foreach($healthCenters->unique('barangay') as $healthCenter)
            <option
                value="{{ $healthCenter->barangay }}"
                {{ old('barangay') === $healthCenter->barangay ? 'selected' : '' }}
            >
                {{ $healthCenter->barangay }}
            </option>
        @endforeach
    </select>
</div>

                <div class="ek-field ek-field--full">
                    <label for="address">Address</label>

                    <textarea
                        id="address"
                        class="ek-input"
                        name="address"
                        required
                    >{{ old('address') }}</textarea>
                </div>

      <div class="ek-field">
    <label for="health_center_id">Health Center</label>

    <select
        id="health_center_id"
        name="health_center_id"
        class="ek-input"
        required
    >
        <option value="" disabled selected>
            Select your health center
        </option>

        @foreach($healthCenters as $healthCenter)
            <option
                value="{{ $healthCenter->id }}"
                data-barangay="{{ $healthCenter->barangay }}"
                {{ old('health_center_id') == $healthCenter->id ? 'selected' : '' }}
            >
                {{ $healthCenter->barangay }} / {{ $healthCenter->name }}
            </option>
        @endforeach
    </select>
</div>

                <h3 class="ek-section-title">Emergency contact</h3>

                <div class="ek-field">
                    <label for="emergency_contact_name">Emergency Contact Name</label>
                  <input
    id="emergency_contact_name"
    class="ek-input"
    type="text"
    name="emergency_contact_name"
    value="{{ old('emergency_contact_name') }}"
    required
>
                </div>

                <div class="ek-field">
                    <label for="emergency_contact_number">Emergency Contact Number</label>
                    <input
                        id="emergency_contact_number"
                        class="ek-input"
                        type="tel"
                        name="emergency_contact_number"
                        value="{{ old('emergency_contact_number') }}"
                        required
                    >
                </div>

                <div class="ek-field ek-field--full">
                    <button type="submit" class="ek-btn">
                        Register
                    </button>
                </div>
            </form>

            <p class="ek-foot">
                Already have an account?
                <a href="{{ route('login') }}" class="ek-link">Login</a>
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

    const barangaySelect = document.getElementById('barangay');
const healthCenterSelect = document.getElementById('health_center_id');

function filterHealthCenters() {
    const selectedBarangay = barangaySelect.value;

    Array.from(healthCenterSelect.options).forEach(function (option) {

        if (!option.value) {
            return;
        }

        const optionBarangay = option.dataset.barangay;

        option.hidden = optionBarangay !== selectedBarangay;
    });

    const currentOption = healthCenterSelect.options[
        healthCenterSelect.selectedIndex
    ];

    if (
        currentOption &&
        currentOption.value &&
        currentOption.dataset.barangay !== selectedBarangay
    ) {
        healthCenterSelect.value = '';
    }
}

barangaySelect.addEventListener('change', filterHealthCenters);

filterHealthCenters();
</script>

</body>
</html>