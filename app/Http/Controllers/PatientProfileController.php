<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientProfileController extends Controller
{
    /**
     * Display the patient's profile.
     */
    public function show(): View
    {
        $user = auth()->user();
        $patient = $user->patient;

        return view('patient.profile', compact(
            'user',
            'patient'
        ));
    }

    /**
     * Update the patient's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $patient = $user->patient;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_number' => ['nullable', 'string', 'max:30'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($patient) {
            $patient->update([
                'contact_number' => $validated['contact_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
            ]);
        }

        return redirect()
            ->route('patient.profile')
            ->with('success', 'Profile updated successfully.');
    }
}