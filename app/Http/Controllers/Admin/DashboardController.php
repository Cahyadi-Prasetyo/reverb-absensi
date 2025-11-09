<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_attendances' => Attendance::count(),
            'today_attendances' => Attendance::whereDate('check_in', today())->count(),
            'on_time_today' => Attendance::whereDate('check_in', today())
                ->where('status', 'on_time')
                ->count(),
            'late_today' => Attendance::whereDate('check_in', today())
                ->where('status', 'late')
                ->count(),
        ];

        $recent_attendances = Attendance::with('user')
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_attendances' => $recent_attendances,
        ]);
    }
}
