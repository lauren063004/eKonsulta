<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }
}
