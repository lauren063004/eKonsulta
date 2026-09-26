<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\HealthCenter;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminStaffController extends Controller
{
    /**
     * Display all staff members.
     */
    public function index(): View
    {
        $staff = Staff::with([
            'user',
            'healthCenter',
        ])
        ->latest()
        ->get();

        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Show create staff form.
     */
    public function create(): View
    {
        $healthCenters = HealthCenter::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.staff.create', compact('healthCenters'));
    }

    /**
     * Store a new staff member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],

            'health_center_id' => [
                'required',
                'exists:health_centers,id',
            ],

            'employee_number' => [
                'required',
                'string',
                'max:100',
                'unique:staff,employee_number',
            ],

            'position' => [
                'required',
                'string',
                'max:100',
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'status' => 'active',
        ]);

        Staff::create([
            'user_id' => $user->id,
            'health_center_id' => $validated['health_center_id'],
            'employee_number' => $validated['employee_number'],
            'position' => $validated['position'],
            'contact_number' => $validated['contact_number'] ?? null,
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Display staff details.
     */
    public function show(Staff $staff): View
    {
        $staff->load([
            'user',
            'healthCenter',
        ]);

        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show edit staff form.
     */
    public function edit(Staff $staff): View
    {
        $staff->load('user');

        $healthCenters = HealthCenter::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.staff.edit', compact(
            'staff',
            'healthCenters'
        ));
    }

    /**
     * Update staff member.
     */
    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $staff->load('user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $staff->user_id,
            ],

            'health_center_id' => [
                'required',
                'exists:health_centers,id',
            ],

            'employee_number' => [
                'required',
                'string',
                'max:100',
                'unique:staff,employee_number,' . $staff->id,
            ],

            'position' => [
                'required',
                'string',
                'max:100',
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $staff->user->name = $validated['name'];
        $staff->user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $staff->user->password = Hash::make(
                $validated['password']
            );
        }

        $staff->user->save();

        $staff->update([
            'health_center_id' => $validated['health_center_id'],
            'employee_number' => $validated['employee_number'],
            'position' => $validated['position'],
            'contact_number' => $validated['contact_number'] ?? null,
        ]);

        return redirect()
            ->route('admin.staff.show', $staff)
            ->with('success', 'Staff information updated successfully.');
    }

    /**
     * Toggle staff account status.
     */
    public function toggleStatus(Staff $staff): RedirectResponse
    {
        $staff->load('user');

        if ($staff->user_id === auth()->id()) {
            return redirect()
                ->route('admin.staff.index')
                ->with(
                    'error',
                    'You cannot deactivate your own administrator account.'
                );
        }

        $staff->user->status = $staff->user->status === 'active'
            ? 'inactive'
            : 'active';

        $staff->user->save();

        $message = $staff->user->status === 'active'
            ? 'Staff account activated successfully.'
            : 'Staff account deactivated successfully.';

        return redirect()
            ->route('admin.staff.index')
            ->with('success', $message);
    }
}