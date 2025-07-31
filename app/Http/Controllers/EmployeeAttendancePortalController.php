<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeShift;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeAttendancePortalController extends Controller
{
    /**
     * Display the employee attendance portal
     */
    public function index()
    {
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            // For admin users, we'll show a demo view or allow them to select an employee
            // Get a sample employee for demo purposes
            $employee = Employee::first();
            
            if (!$employee) {
                return redirect()->route('dashboard')
                    ->with('error', 'Tidak ada data karyawan untuk ditampilkan. Silakan tambahkan karyawan terlebih dahulu.');
            }
            
            // Set a flag to indicate this is admin view mode
            $isAdminView = true;
        } else {
            // For regular employees, get their own record
            $employee = Employee::where('user_id', $user->id)->first();
            
            if (!$employee) {
                return redirect()->route('dashboard')
                    ->with('error', 'Profil karyawan tidak ditemukan. Silakan hubungi admin.');
            }
            
            $isAdminView = false;
        }
        
        // Get today's attendance record if exists
        $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->first();
        
        // Get employee's shift for today if exists
        $todayShift = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', Carbon::today()->toDateString())
            ->first();
        
        // Get attendance history for the current week
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $weeklyAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$weekStart, $weekEnd])
            ->orderBy('attendance_date', 'desc')
            ->get();
        
        // Get active projects
        if ($isAdminView) {
            // For admin view, just get all active projects
            $activeProjects = Project::where('status', 'active')
                ->limit(5) // Limit to 5 projects for demo
                ->get();
        } else {
            // For employee view, try to get projects where employee is submitter or initiator
            $activeProjects = Project::where(function($query) use ($employee) {
                $query->where('submitter_employee_id', $employee->id)
                    ->orWhere('initiator_employee_id', $employee->id);
            })
            ->where('status', 'active')
            ->get();
        }
        
        // Get attendance statistics for the current month
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $statistics = EmployeeAttendance::getAttendanceStatistics(
            $employee->id,
            $monthStart->toDateString(),
            $monthEnd->toDateString()
        );
        
        // Get attendance methods
        $attendanceMethods = EmployeeAttendance::getAttendanceMethodOptions();
        
        // Get work locations
        $workLocations = EmployeeAttendance::getWorkLocationOptions();
        
        return view('employee-attendance-portal.index', compact(
            'employee',
            'todayAttendance',
            'todayShift',
            'weeklyAttendance',
            'activeProjects',
            'statistics',
            'attendanceMethods',
            'workLocations',
            'isAdminView'
        ));
    }
    
    /**
     * Process time-in request
     */
    public function timeIn(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'attendance_method' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceMethodOptions())),
            'work_location' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getWorkLocationOptions())),
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'selfie_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
            'notes' => 'nullable|string|max:255',
        ]);
        
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak dapat melakukan absensi. Silakan login sebagai karyawan untuk menggunakan fitur ini.'
            ], 403);
        }
        
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // Check if already clocked in today
        $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->first();
        
        // Handle selfie image upload if provided
        $selfiePath = null;
        if ($request->hasFile('selfie_image')) {
            $file = $request->file('selfie_image');
            $filename = time() . '_' . $employee->id . '_in_' . $file->getClientOriginalName();
            $selfiePath = $file->storeAs('attendance_selfies', $filename, 'public');
        }
        
        // Get current time
        $currentTime = Carbon::now()->format('H:i');
        
        // Get employee's shift for today if exists
        $todayShift = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', Carbon::today()->toDateString())
            ->first();
        
        // Determine if late based on shift
        $isLate = false;
        $attendanceStatus = 'hadir';
        
        if ($todayShift) {
            $shiftStartTime = Carbon::parse($todayShift->start_time);
            $actualTimeIn = Carbon::parse($currentTime);
            
            if ($actualTimeIn->gt($shiftStartTime->addMinutes(15))) { // 15 minutes tolerance
                $isLate = true;
                $attendanceStatus = 'terlambat';
            }
        }
        
        if ($todayAttendance) {
            // Add new time log to existing attendance record
            $todayAttendance->addTimeLog($currentTime, null, $validated['notes'] ?? null);
            
            // Update attendance record with new data
            $todayAttendance->attendance_method = $validated['attendance_method'];
            $todayAttendance->work_location = $validated['work_location'];
            $todayAttendance->latitude = $validated['latitude'];
            $todayAttendance->longitude = $validated['longitude'];
            $todayAttendance->device_info = $request->header('User-Agent');
            $todayAttendance->ip_address = $request->ip();
            
            // Add selfie path to notes if uploaded
            if ($selfiePath) {
                $notes = $todayAttendance->notes ?? '';
                $todayAttendance->notes = $notes . "\nSelfie masuk: " . $selfiePath;
            }
            
            $todayAttendance->save();
            
            $message = 'Absen masuk berhasil dicatat. Anda telah melakukan absen masuk sebelumnya hari ini.';
        } else {
            // Create new attendance record
            $attendanceData = [
                'employee_id' => $employee->id,
                'employee_name' => $employee->full_name,
                'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
                'attendance_date' => Carbon::today()->toDateString(),
                'time_in' => $currentTime,
                'attendance_status' => $attendanceStatus,
                'day_type' => $this->determineDayType(Carbon::today()),
                'work_location' => $validated['work_location'],
                'attendance_method' => $validated['attendance_method'],
                'supervisor_verification' => 'not_required',
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'notes' => $validated['notes'],
                'attendance_input_date' => now(),
                'data_updated_at' => now(),
                'ip_address' => $request->ip(),
                'device_info' => $request->header('User-Agent'),
                'employee_shift_id' => $todayShift ? $todayShift->id : null,
            ];
            
            // Add selfie path to notes if uploaded
            if ($selfiePath) {
                $attendanceData['notes'] = ($attendanceData['notes'] ?? '') . "\nSelfie masuk: " . $selfiePath;
            }
            
            $todayAttendance = EmployeeAttendance::create($attendanceData);
            
            $message = 'Absen masuk berhasil dicatat.';
        }
        
        // Return response
        return response()->json([
            'success' => true,
            'message' => $message,
            'is_late' => $isLate,
            'attendance' => $todayAttendance->load('employeeShift')
        ]);
    }
    
    /**
     * Process time-out request
     */
    public function timeOut(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'selfie_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
            'notes' => 'nullable|string|max:255',
        ]);
        
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak dapat melakukan absensi. Silakan login sebagai karyawan untuk menggunakan fitur ini.'
            ], 403);
        }
        
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // Check if already clocked in today
        $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->first();
        
        if (!$todayAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini.'
            ], 400);
        }
        
        // Handle selfie image upload if provided
        $selfiePath = null;
        if ($request->hasFile('selfie_image')) {
            $file = $request->file('selfie_image');
            $filename = time() . '_' . $employee->id . '_out_' . $file->getClientOriginalName();
            $selfiePath = $file->storeAs('attendance_selfies', $filename, 'public');
        }
        
        // Get current time
        $currentTime = Carbon::now()->format('H:i');
        
        // Get employee's shift for today if exists
        $todayShift = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', Carbon::today()->toDateString())
            ->first();
        
        // Determine if early departure based on shift
        $isEarlyDeparture = false;
        
        if ($todayShift) {
            $shiftEndTime = Carbon::parse($todayShift->end_time);
            $actualTimeOut = Carbon::parse($currentTime);
            
            if ($actualTimeOut->lt($shiftEndTime->subMinutes(15))) { // 15 minutes tolerance
                $isEarlyDeparture = true;
                
                // Update attendance status if leaving early
                if ($todayAttendance->attendance_status === 'hadir') {
                    $todayAttendance->attendance_status = 'pulang_cepat';
                }
            }
        }
        
        // Update the latest time log or main time_out
        if ($todayAttendance->time_logs && count($todayAttendance->time_logs) > 0) {
            $timeLogs = $todayAttendance->time_logs;
            $lastIndex = count($timeLogs) - 1;
            
            if (!isset($timeLogs[$lastIndex]['time_out'])) {
                $timeLogs[$lastIndex]['time_out'] = $currentTime;
                $timeLogs[$lastIndex]['notes'] = $validated['notes'] ?? $timeLogs[$lastIndex]['notes'];
                $timeLogs[$lastIndex]['updated_at'] = now()->toISOString();
                
                $todayAttendance->time_logs = $timeLogs;
            } else {
                // Add new time log for time-out only
                $todayAttendance->addTimeLog(null, $currentTime, $validated['notes']);
            }
        } else {
            $todayAttendance->time_out = $currentTime;
        }
        
        // Add selfie path to notes if uploaded
        if ($selfiePath) {
            $notes = $todayAttendance->notes ?? '';
            $todayAttendance->notes = $notes . "\nSelfie pulang: " . $selfiePath;
        }
        
        // Add notes if provided
        if (isset($validated['notes']) && !empty($validated['notes'])) {
            $existingNotes = $todayAttendance->notes ?? '';
            $todayAttendance->notes = $existingNotes . "\nCatatan pulang: " . $validated['notes'];
        }
        
        $todayAttendance->data_updated_at = now();
        $todayAttendance->save();
        
        // Calculate work duration
        $todayAttendance->calculateWorkDuration();
        $todayAttendance->save();
        
        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil dicatat.',
            'is_early_departure' => $isEarlyDeparture,
            'attendance' => $todayAttendance->load('employeeShift')
        ]);
    }
    
    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:2030',
        ]);
        
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            // For admin users, we'll show a demo history
            // Get a sample employee for demo purposes
            $employee = Employee::first();
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data karyawan untuk ditampilkan.'
                ], 404);
            }
            
            // Return demo data
            return response()->json([
                'success' => true,
                'attendances' => [],
                'statistics' => [
                    'total_days' => 30,
                    'present_days' => 22,
                    'absent_days' => 8,
                    'late_days' => 2,
                    'pending_verification' => 0,
                    'total_work_hours' => 176,
                    'average_work_hours' => 8
                ],
                'period' => [
                    'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                    'end_date' => Carbon::now()->endOfMonth()->toDateString(),
                ],
                'is_admin_view' => true
            ]);
        }
        
        // For regular employees, get their own record
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // Determine date range
        if (isset($validated['start_date']) && isset($validated['end_date'])) {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
        } elseif (isset($validated['month']) && isset($validated['year'])) {
            $startDate = Carbon::createFromDate($validated['year'], $validated['month'], 1)->startOfMonth();
            $endDate = Carbon::createFromDate($validated['year'], $validated['month'], 1)->endOfMonth();
        } else {
            // Default to current month
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }
        
        // Get attendance records
        $attendances = EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('attendance_date', 'desc')
            ->get();
        
        // Get statistics
        $statistics = EmployeeAttendance::getAttendanceStatistics(
            $employee->id,
            $startDate->toDateString(),
            $endDate->toDateString()
        );
        
        // Return response
        return response()->json([
            'success' => true,
            'attendances' => $attendances,
            'statistics' => $statistics,
            'period' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ]
        ]);
    }
    
    /**
     * Get today's attendance status
     */
    public function todayStatus()
    {
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            // For admin users, we'll show a demo status
            // Get a sample employee for demo purposes
            $employee = Employee::first();
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data karyawan untuk ditampilkan.'
                ], 404);
            }
            
            // Return demo data
            return response()->json([
                'success' => true,
                'has_checked_in' => true,
                'has_checked_out' => false,
                'attendance' => null,
                'shift' => null,
                'current_time' => Carbon::now()->format('H:i:s'),
                'current_date' => Carbon::now()->format('Y-m-d'),
                'is_admin_view' => true
            ]);
        }
        
        // For regular employees, get their own record
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // Get today's attendance record if exists
        $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->first();
        
        // Get employee's shift for today if exists
        $todayShift = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', Carbon::today()->toDateString())
            ->first();
        
        return response()->json([
            'success' => true,
            'has_checked_in' => $todayAttendance ? true : false,
            'has_checked_out' => $todayAttendance && $todayAttendance->time_out ? true : false,
            'attendance' => $todayAttendance,
            'shift' => $todayShift,
            'current_time' => Carbon::now()->format('H:i:s'),
            'current_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }
    
    /**
     * Submit daily task report
     */
    public function submitTaskReport(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.description' => 'required|string',
            'tasks.*.status' => 'required|in:completed,in_progress,planned',
            'tasks.*.project_id' => 'nullable|exists:projects,id',
            'summary' => 'nullable|string',
        ]);
        
        // Get the authenticated user's employee record
        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role && $user->role->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak dapat mengirim laporan tugas. Silakan login sebagai karyawan untuk menggunakan fitur ini.'
            ], 403);
        }
        
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // Get today's attendance record
        $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->first();
        
        if (!$todayAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini.'
            ], 400);
        }
        
        // Format task report
        $taskReport = [
            'tasks' => $validated['tasks'],
            'summary' => $validated['summary'] ?? '',
            'submitted_at' => now()->toISOString(),
        ];
        
        // Update attendance record with task report
        $existingNotes = $todayAttendance->notes ?? '';
        $todayAttendance->notes = $existingNotes . "\n\nLAPORAN TUGAS HARIAN:\n" . json_encode($taskReport, JSON_PRETTY_PRINT);
        $todayAttendance->save();
        
        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Laporan tugas harian berhasil disimpan.',
            'attendance' => $todayAttendance
        ]);
    }
    
    /**
     * Helper method to determine day type
     */
    private function determineDayType($date)
    {
        $carbonDate = Carbon::parse($date);
        
        if ($carbonDate->isWeekend()) {
            return 'akhir_pekan';
        }
        
        // You can add logic here to check for national holidays
        // For now, default to working day
        return 'hari_kerja';
    }
}
