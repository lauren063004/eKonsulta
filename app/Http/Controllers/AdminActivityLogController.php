<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\View\View;

class AdminActivityLogController extends Controller
{
    /**
     * Display system activity logs.
     */
    public function index(): View
    {
        $activityLogs = ActivityLog::with('user')
            ->latest()
            ->get();

        return view('admin.activity-logs.index', compact('activityLogs'));
    }
}