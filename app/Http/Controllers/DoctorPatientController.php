<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    /**
     * Display patients who have appointments with the logged-in doctor.
     */
    public function index(): View
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor record not found.');
        }

        $patients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
        ->with('user')
        ->orderBy('id')
        ->get();

        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Display a patient's clinical profile for the logged-in doctor.
     */
    public function show(Patient $patient): View
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor record not found.');
        }

        // Make sure this patient has an appointment with this doctor.
        $hasAppointment = $patient->appointments()
            ->where('doctor_id', $doctor->id)
            ->exists();

        if (!$hasAppointment) {
            abort(403, 'You are not authorized to view this patient.');
        }

        $patient->load([
            'user',
            'appointments' => function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id)
                    ->with('healthCenter')
                    ->latest('appointment_date');
            },
            'consultations' => function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id)
                    ->latest('consultation_date');
            },
            'prescriptions' => function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id)
                    ->with('items')
                    ->latest();
            },
        ]);

        return view('doctor.patients.show', compact('patient'));
    }
}