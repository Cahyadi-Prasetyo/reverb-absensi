<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Temporary: No auth for demo purposes
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

// Login route for testing
Route::get('/login/{userId}', function ($userId) {
    Auth::loginUsingId($userId);
    return redirect('/');
})->name('login.quick');
