<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DoctorProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        return view('doctor.profile', compact('user', 'doctor'));
    }
}
