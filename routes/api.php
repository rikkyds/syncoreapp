<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeAttendancePortalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Employee project check route
Route::get('/employee/{employee}/projects', [EmployeeController::class, 'checkProjects']);

// Employee Attendance Portal API Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Attendance status and operations
    Route::get('/attendance/today-status', [EmployeeAttendancePortalController::class, 'todayStatus']);
    Route::post('/attendance/time-in', [EmployeeAttendancePortalController::class, 'timeIn']);
    Route::post('/attendance/time-out', [EmployeeAttendancePortalController::class, 'timeOut']);
    
    // Attendance history and reports
    Route::get('/attendance/history', [EmployeeAttendancePortalController::class, 'history']);
    
    // Daily task reporting
    Route::post('/attendance/task-report', [EmployeeAttendancePortalController::class, 'submitTaskReport']);
});
