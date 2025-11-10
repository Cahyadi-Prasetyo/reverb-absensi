<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $attendanceService)
    {
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
            ], 401);
        }

        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $result = $this->attendanceService->createAttendance([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'timestamp' => now(),
        ]);

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, 422);
    }

    public function index()
    {
        $attendances = $this->attendanceService->getTodayAttendances();
        return response()->json($attendances);
    }
}
