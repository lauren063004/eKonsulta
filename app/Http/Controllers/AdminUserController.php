<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display all system users.
     */
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display user details.
     */
    public function show(User $user): View
    {
        $user->load([
            'patient',
            'doctor',
            'staff',
        ]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Toggle a user's active status.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        // Prevent the administrator from disabling their own account.
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own administrator account.');
        }

        $user->status = $user->status === 'active'
            ? 'inactive'
            : 'active';

        $user->save();

        $message = $user->status === 'active'
            ? 'User account activated successfully.'
            : 'User account deactivated successfully.';

        return redirect()
            ->route('admin.users.index')
            ->with('success', $message);
    }
}