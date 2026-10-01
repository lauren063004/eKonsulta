<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | e-Konsulta</title>

    <link rel="icon" href="{{ asset('images/cross-badge.jpg') }}">

    @vite('resources/js/app.js')

    <style>
        /* =========================================================
           e-KONSULTA REGISTRATION
           Clean / Natural / Healthcare UI
           ========================================================= */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            color: #172033;
        }


        /* =========================================================
           PAGE
           ========================================================= */

        .register-page {
            min-height: 100vh;
            min-height: 100dvh;

            width: 100%;

            display: flex;
            align-items: center;

            padding: 30px 45px;

            background:
                linear-gradient(
                    90deg,
                    rgba(4, 38, 65, .48),
                    rgba(4, 38, 65, .12)
                ),
                url("/images/hero-bg.jpg");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            overflow-y: auto;
        }


        /* =========================================================
           MAIN LANDSCAPE LAYOUT
           ========================================================= */

        .register-layout {
            width: min(1120px, 100%);

            margin: 0 auto;

            display: grid;

            grid-template-columns: 390px minmax(0, 1fr);

            gap: 45px;

            align-items: center;
        }


        /* =========================================================
           LEFT BRAND
           ========================================================= */

        .register-brand {
            color: #fff;

            padding: 10px 0;
        }

        .register-brand-top {
            display: flex;
            align-items: center;

            gap: 13px;

            margin-bottom: 34px;
        }

        .register-brand-logo {
            width: 60px;
            height: 60px;

            object-fit: contain;

            padding: 3px;

            background: #fff;

            border-radius: 50%;

            box-shadow:
                0 8px 25px rgba(0, 0, 0, .2);
        }

        .register-brand-name {
            display: flex;
            flex-direction: column;

            gap: 3px;
        }

        .register-brand-name strong {
            font-size: 27px;

            line-height: 1;

            font-weight: 750;

            letter-spacing: -.4px;
        }

        .register-brand-name span {
            font-size: 12px;

            color: rgba(255,255,255,.88);
        }

        .register-brand h2 {
            margin: 0;

            font-size: 42px;

            line-height: 1.08;

            font-weight: 750;

            letter-spacing: -1.2px;

            text-shadow:
                0 3px 15px rgba(0,0,0,.2);
        }

        .register-brand h2 em {
            font-style: normal;
        }

        .register-brand-description {
            margin: 18px 0 0;

            max-width: 370px;

            font-size: 14px;

            line-height: 1.65;

            color: rgba(255,255,255,.92);

            text-shadow:
                0 2px 8px rgba(0,0,0,.16);
        }


        /* =========================================================
           REGISTRATION CARD
           ========================================================= */

        .register-card {
            width: 100%;

            background: rgba(255,255,255,.96);

            border: 1px solid rgba(255,255,255,.75);

            border-radius: 18px;

            padding: 25px 28px;

            box-shadow:
                0 24px 55px rgba(0,0,0,.20),
                0 5px 18px rgba(0,0,0,.08);

            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }


        /* =========================================================
           CARD HEADER
           ========================================================= */

        .register-header {
            margin-bottom: 19px;
        }

        .register-header h1 {
            margin: 0;

            font-size: 24px;

            line-height: 1.2;

            font-weight: 750;

            color: #172033;

            letter-spacing: -.4px;
        }

        .register-header p {
            margin: 5px 0 0;

            font-size: 12px;

            color: #718096;
        }


        /* =========================================================
           ALERT
           ========================================================= */

        .register-alert {
            margin-bottom: 15px;

            padding: 10px 12px;

            border-radius: 9px;

            font-size: 12px;
        }

        .register-alert-danger {
            color: #a52626;

            background: #fff2f2;

            border: 1px solid #ffd6d6;
        }

        .register-alert-success {
            color: #267344;

            background: #effaf3;

            border: 1px solid #ccebd7;
        }

        .register-alert ul {
            margin: 5px 0 0 17px;

            padding: 0;
        }


        /* =========================================================
           FORM
           ========================================================= */

        .register-form {
            display: flex;
            flex-direction: column;

            gap: 13px;
        }

        .register-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 11px 14px;
        }

        .register-full {
            grid-column: 1 / -1;
        }


        /* =========================================================
           FIELD
           ========================================================= */

        .register-field label {
            display: block;

            margin-bottom: 5px;

            font-size: 11px;

            line-height: 1.2;

            font-weight: 650;

            color: #344054;
        }

        .register-field label span {
            color: #c62828;
        }

        .register-field label small {
            color: #98a2b3;

            font-weight: 400;
        }

        .register-field input,
        .register-field select,
        .register-field textarea {
            width: 100%;

            border: 1px solid #d9dee7;

            border-radius: 8px;

            background: #fff;

            color: #172033;

            font-family: inherit;

            font-size: 12px;

            outline: none;

            transition:
                border-color .15s ease,
                box-shadow .15s ease;
        }

        .register-field input,
        .register-field select {
            height: 38px;

            padding: 0 10px;
        }

        .register-field textarea {
            min-height: 58px;

            padding: 9px 10px;

            resize: vertical;
        }

        .register-field input::placeholder,
        .register-field textarea::placeholder {
            color: #a6afbd;
        }

        .register-field input:focus,
        .register-field select:focus,
        .register-field textarea:focus {
            border-color: #0b4f8a;

            box-shadow:
                0 0 0 3px rgba(11,79,138,.08);
        }


        /* =========================================================
           PASSWORD
           ========================================================= */

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 50px;
        }

        .password-toggle {
            position: absolute;

            top: 50%;
            right: 8px;

            transform: translateY(-50%);

            border: 0;

            background: transparent;

            color: #0b4f8a;

            font-family: inherit;

            font-size: 10px;

            font-weight: 700;

            cursor: pointer;

            padding: 4px;
        }


        /* =========================================================
           BUTTON
           ========================================================= */

        .register-button {
            width: 100%;

            height: 42px;

            margin-top: 3px;

            border: 0;

            border-radius: 8px;

            background: #0b4f8a;

            color: #fff;

            font-family: inherit;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 6px 14px rgba(11,79,138,.18);

            transition:
                background .15s ease,
                transform .15s ease;
        }

        .register-button:hover {
            background: #083e6d;

            transform: translateY(-1px);
        }


        /* =========================================================
           BOTTOM LINKS
           ========================================================= */

        .register-switch {
            margin: 13px 0 0;

            text-align: center;

            font-size: 11px;

            color: #718096;
        }

        .register-switch a {
            color: #0b4f8a;

            font-weight: 700;

            text-decoration: none;
        }

        .register-switch a:hover {
            text-decoration: underline;
        }

        .register-foot {
            margin: 9px 0 0;

            text-align: center;

            font-size: 9px;

            color: #9aa3b2;
        }


        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 1000px) {

            .register-page {
                padding: 25px;
            }

            .register-layout {
                grid-template-columns: 1fr;

                max-width: 650px;

                gap: 25px;
            }

            .register-brand {
                text-align: center;
            }

            .register-brand-top {
                justify-content: center;

                margin-bottom: 18px;
            }

            .register-brand-description {
                margin-left: auto;
                margin-right: auto;
            }

            .register-brand h2 {
                font-size: 34px;
            }
        }


        /* =========================================================
           MOBILE
           ========================================================= */

        @media (max-width: 600px) {

            .register-page {
                padding: 15px 10px;
            }

            .register-card {
                padding: 20px 17px;

                border-radius: 15px;
            }

            .register-grid {
                grid-template-columns: 1fr;
            }

            .register-brand h2 {
                font-size: 29px;
            }

            .register-brand-name strong {
                font-size: 23px;
            }

            .register-header h1 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<main class="register-page">

    <div class="register-layout">

        {{-- =====================================================
             LEFT: BRANDING
             ===================================================== --}}

        <section class="register-brand">

            <div class="register-brand-top">

                <img
                    class="register-brand-logo"
                    src="{{ asset('images/cho-seal.jpg') }}"
                    alt="City Health Office of Taguig seal"
                >

                <div class="register-brand-name">

                    <strong>e-Konsulta</strong>

                    <span>
                        City Health Office &bull; City of Taguig
                    </span>

                </div>

            </div>


            <h2>
                Quality healthcare,
                <em>closer</em>
                to every family.
            </h2>


            <p class="register-brand-description">
                Create your e-Konsulta account to book consultations,
                access prescriptions, and manage your health records
                through your local health center.
            </p>

        </section>


        {{-- =====================================================
             RIGHT: FORM
             ===================================================== --}}

        <section class="register-panel">

            <div class="register-card">

                <div class="register-header">

                    <h1>Create your account</h1>

                    <p>
                        Register as a patient to get started.
                    </p>

                </div>


                {{-- =================================================
                     VALIDATION ERRORS
                     ================================================= --}}

                @if ($errors->any())

                    <div class="register-alert register-alert-danger">

                        <strong>
                            Please check the following:
                        </strong>

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- =================================================
                     SUCCESS MESSAGE
                     ================================================= --}}

                @if (session('success'))

                    <div class="register-alert register-alert-success">

                        {{ session('success') }}

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('register.store') }}"
                    class="register-form"
                >

                    @csrf


                    {{-- =================================================
                         NAME
                         ================================================= --}}

                    <div class="register-grid">

                        <div class="register-field">

                            <label for="first_name">
                                First Name <span>*</span>
                            </label>

                            <input
                                id="first_name"
                                type="text"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="First name"
                                autocomplete="given-name"
                                required
                            >

                        </div>


                        <div class="register-field">

                            <label for="middle_name">
                                Middle Name
                                <small>(optional)</small>
                            </label>

                            <input
                                id="middle_name"
                                type="text"
                                name="middle_name"
                                value="{{ old('middle_name') }}"
                                placeholder="Middle name"
                                autocomplete="additional-name"
                            >

                        </div>


                        <div class="register-field">

                            <label for="last_name">
                                Last Name <span>*</span>
                            </label>

                            <input
                                id="last_name"
                                type="text"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Last name"
                                autocomplete="family-name"
                                required
                            >

                        </div>


                        <div class="register-field">

                            <label for="suffix">
                                Suffix
                                <small>(optional)</small>
                            </label>

                            <input
                                id="suffix"
                                type="text"
                                name="suffix"
                                value="{{ old('suffix') }}"
                                placeholder="Jr., Sr., III"
                            >

                        </div>


                        <div class="register-field">

                            <label for="date_of_birth">
                                Date of Birth <span>*</span>
                            </label>

                            <input
                                id="date_of_birth"
                                type="date"
                                name="date_of_birth"
                                value="{{ old('date_of_birth') }}"
                                required
                            >

                        </div>


                        <div class="register-field">

                            <label for="sex">
                                Sex <span>*</span>
                            </label>

                            <select
                                id="sex"
                                name="sex"
                                required
                            >

                                <option value="">
                                    Select sex
                                </option>

                                <option
                                    value="Male"
                                    @selected(old('sex') === 'Male')
                                >
                                    Male
                                </option>

                                <option
                                    value="Female"
                                    @selected(old('sex') === 'Female')
                                >
                                    Female
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- =================================================
                         CONTACT / LOCATION
                         ================================================= --}}

                    <div class="register-grid">

                        <div class="register-field">

                            <label for="contact_number">
                                Contact Number <span>*</span>
                            </label>

                            <input
                                id="contact_number"
                                type="text"
                                name="contact_number"
                                value="{{ old('contact_number') }}"
                                placeholder="09XXXXXXXXX"
                                autocomplete="tel"
                                required
                            >

                        </div>


                        {{-- =================================================
                             BARANGAY
                             ================================================= --}}

                        <div class="register-field">

                            <label for="barangay">
                                Barangay <span>*</span>
                            </label>

                            <select
                                id="barangay"
                                name="barangay"
                                required
                            >

                                <option value="">
                                    Select barangay
                                </option>

                                @foreach ($barangays as $barangay)

                                    <option
                                        value="{{ $barangay }}"
                                        @selected(old('barangay') === $barangay)
                                    >
                                        {{ $barangay }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                             HEALTH CENTER
                             ================================================= --}}

                        <div class="register-field">

                            <label for="health_center_id">
                                Health Center <span>*</span>
                            </label>

                            <select
                                id="health_center_id"
                                name="health_center_id"
                                required
                            >

                                <option value="">
                                    Select health center
                                </option>

                                @foreach ($healthCenters as $healthCenter)

                                    <option
                                        value="{{ $healthCenter->id }}"
                                        data-barangay="{{ $healthCenter->barangay }}"
                                        @selected(old('health_center_id') == $healthCenter->id)
                                    >
                                        {{ $healthCenter->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="register-field">

                            <label for="address">
                                Complete Address <span>*</span>
                            </label>

                            <input
                                id="address"
                                type="text"
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="House/Unit No., Street, Barangay"
                                required
                            >

                        </div>

                    </div>


                    {{-- =================================================
                         EMERGENCY CONTACT
                         ================================================= --}}

                    <div class="register-grid">

                        <div class="register-field">

                            <label for="emergency_contact_name">
                                Emergency Contact <span>*</span>
                            </label>

                            <input
                                id="emergency_contact_name"
                                type="text"
                                name="emergency_contact_name"
                                value="{{ old('emergency_contact_name') }}"
                                placeholder="Full name"
                                required
                            >

                        </div>


                        <div class="register-field">

                            <label for="emergency_contact_number">
                                Emergency Contact Number <span>*</span>
                            </label>

                            <input
                                id="emergency_contact_number"
                                type="text"
                                name="emergency_contact_number"
                                value="{{ old('emergency_contact_number') }}"
                                placeholder="09XXXXXXXXX"
                                required
                            >

                        </div>

                    </div>


                    {{-- =================================================
                         ACCOUNT
                         ================================================= --}}

                    <div class="register-grid">

                        <div class="register-field register-full">

                            <label for="email">
                                Email Address <span>*</span>
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                            >

                        </div>


                        {{-- =================================================
                             PASSWORD
                             ================================================= --}}

                        <div class="register-field">

                            <label for="password">
                                Password <span>*</span>
                            </label>

                            <div class="password-field">

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Create a password"
                                    autocomplete="new-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password"
                                >
                                    Show
                                </button>

                            </div>

                        </div>


                        {{-- =================================================
                             CONFIRM PASSWORD
                             ================================================= --}}

                        <div class="register-field">

                            <label for="password_confirmation">
                                Confirm Password <span>*</span>
                            </label>

                            <div class="password-field">

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Repeat password"
                                    autocomplete="new-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password_confirmation"
                                >
                                    Show
                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SUBMIT
                         ================================================= --}}

                    <button
                        type="submit"
                        class="register-button"
                    >
                        Create Patient Account
                    </button>

                </form>


                {{-- =================================================
                     LOGIN LINK
                     ================================================= --}}

                <p class="register-switch">

                    Already have an account?

                    <a href="{{ route('login') }}">
                        Sign in
                    </a>

                </p>


                <p class="register-foot">

                    &copy; {{ date('Y') }}
                    City Health Office of Taguig.
                    All rights reserved.

                </p>

            </div>

        </section>

    </div>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       Password visibility
       ========================================================= */

    document
        .querySelectorAll('.password-toggle')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const input = document.getElementById(
                    button.dataset.target
                );

                if (!input) {
                    return;
                }

                if (input.type === 'password') {

                    input.type = 'text';

                    button.textContent = 'Hide';

                } else {

                    input.type = 'password';

                    button.textContent = 'Show';

                }

            });

        });


    /* =========================================================
       Barangay → Health Center filtering
       ========================================================= */

    const barangaySelect =
        document.getElementById('barangay');

    const healthCenterSelect =
        document.getElementById('health_center_id');


    if (barangaySelect && healthCenterSelect) {

        function filterHealthCenters() {

            const selectedBarangay =
                barangaySelect.value;


            Array.from(
                healthCenterSelect.options
            ).forEach(function (option) {

                /*
                 * Always keep the placeholder visible.
                 */
                if (!option.value) {

                    option.hidden = false;

                    return;
                }


                const optionBarangay =
                    option.dataset.barangay;


                /*
                 * Show only health centers belonging
                 * to the selected barangay.
                 */
                option.hidden =
                    selectedBarangay !== '' &&
                    optionBarangay !== selectedBarangay;

            });


            /*
             * If the currently selected health center
             * does not belong to the selected barangay,
             * clear it.
             */
            const selectedOption =
                healthCenterSelect.options[
                    healthCenterSelect.selectedIndex
                ];


            if (
                selectedOption &&
                selectedOption.value &&
                selectedOption.dataset.barangay !== selectedBarangay
            ) {

                healthCenterSelect.value = '';

            }

        }


        /*
         * Run whenever the user changes Barangay.
         */
        barangaySelect.addEventListener(
            'change',
            filterHealthCenters
        );


        /*
         * Run once when the page loads.
         *
         * This also preserves old() values after
         * a validation error.
         */
        filterHealthCenters();

    }

});
</script>


</body>
</html>