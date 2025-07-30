<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Company;
use App\Models\BranchOffice;
use App\Models\WorkUnit;
use App\Models\Position;
use App\Models\EmployeeLeave;
use App\Models\EmployeeAttendance;
use App\Models\Project;
use App\Models\SupportRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Check if user has a role
        if ($user->role && $user->role->name) {
            $view = 'dashboards.' . $user->role->name;
            
            // Fallback to default dashboard if view doesn't exist
            if (!view()->exists($view)) {
                $view = 'dashboard';
            }
        } else {
            $view = 'dashboard';
        }
        
        return view($view, compact('stats', 'user'));
    }
    
    private function getDashboardStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        return [
            // Employee Statistics
            'total_employees' => Employee::count(),
            'new_employees_this_month' => Employee::where('created_at', '>=', $thisMonth)->count(),
            'employees_on_probation' => Employee::where('employment_status', 'probation')->count(),
            'permanent_employees' => Employee::where('employment_status', 'permanent')->count(),
            
            // User Statistics
            'total_users' => User::count(),
            'active_users' => User::whereNotNull('email_verified_at')->count(),
            
            // Organization Statistics
            'total_companies' => Company::count(),
            'total_branches' => BranchOffice::count(),
            'total_work_units' => WorkUnit::count(),
            'total_positions' => Position::count(),
            
            // Leave Statistics
            'pending_leaves' => EmployeeLeave::where('status', 'pending')->count(),
            'approved_leaves_today' => EmployeeLeave::where('status', 'approved')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),
            
            // Attendance Statistics
            'attendance_today' => EmployeeAttendance::whereDate('attendance_date', $today)->count(),
            'late_attendance_today' => EmployeeAttendance::whereDate('attendance_date', $today)
                ->where('attendance_status', 'terlambat')->count(),
            
            // Project Statistics
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'in_progress')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            
            // Support Request Statistics
            'pending_support_requests' => SupportRequest::where('status', 'draft')->count(),
            'approved_support_requests' => SupportRequest::where('status', 'approved')->count(),
            
            // Recent Activities
            'recent_employees' => Employee::with(['position', 'workUnit'])
                ->latest()
                ->take(5)
                ->get(),
            'recent_leaves' => EmployeeLeave::with('employee')
                ->latest()
                ->take(5)
                ->get(),
            'recent_projects' => Project::latest()
                ->take(5)
                ->get(),
        ];
    }
}
