<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StaffProfileController extends Controller
{
    public function show(): View
    {
        $staff = Staff::with([
            'user',
            'healthCenter',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('staff.profile.show', compact('staff'));
    }
}