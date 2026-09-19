<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Page
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

 public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'Your account has been deactivated. Please contact the administrator.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    return back()
        ->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])
        ->onlyInput('email');
}


    /*
    |--------------------------------------------------------------------------
    | Role-Based Redirect
    |--------------------------------------------------------------------------
    */

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => abort(403, 'Invalid user role.'),
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Show Registration Page
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | Patient Registration
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],

            'date_of_birth' => [
                'required',
                'date',
            ],

            'sex' => [
                'required',
                'string',
                'max:20',
            ],

            'contact_number' => [
                'required',
                'string',
                'max:30',
            ],

            'address' => [
                'required',
                'string',
            ],

            'emergency_contact_name' => [
                'required',
                'string',
                'max:255',
            ],

            'emergency_contact_number' => [
                'required',
                'string',
                'max:30',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patient',
        ]);

        $patientNumber = 'PAT-' . date('Y') . '-' .
            str_pad($user->id, 5, '0', STR_PAD_LEFT);

        Patient::create([
            'user_id' => $user->id,
            'patient_number' => $patientNumber,
            'date_of_birth' => $validated['date_of_birth'],
            'sex' => $validated['sex'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_number' => $validated['emergency_contact_number'],
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('patient.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}