<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private AttendanceService $attendanceService)
    {
    }

    public function index()
    {
        $attendances = $this->attendanceService->getTodayAttendances();
        $nodeId = config('app.node_id', gethostname());
        
        return view('dashboard', compact('attendances', 'nodeId'));
    }
}
