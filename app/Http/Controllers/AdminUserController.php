<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}