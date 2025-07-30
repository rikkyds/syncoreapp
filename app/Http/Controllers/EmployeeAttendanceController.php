<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $attendances = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('time_in', 'desc')
            ->paginate(15);
        
        return view('employee-attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $shifts = EmployeeShift::with('employee')
            ->where('shift_date', '>=', Carbon::today()->subDays(7))
            ->get();
        
        $attendanceStatuses = EmployeeAttendance::getAttendanceStatusOptions();
        $dayTypes = EmployeeAttendance::getDayTypeOptions();
        $workLocations = EmployeeAttendance::getWorkLocationOptions();
        $attendanceMethods = EmployeeAttendance::getAttendanceMethodOptions();
        $supervisorVerifications = EmployeeAttendance::getSupervisorVerificationOptions();
        
        return view('employee-attendances.create', compact(
            'employees',
            'shifts',
            'attendanceStatuses',
            'dayTypes',
            'workLocations',
            'attendanceMethods',
            'supervisorVerifications'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'attendance_date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'attendance_status' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceStatusOptions())),
            'day_type' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getDayTypeOptions())),
            'work_location' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getWorkLocationOptions())),
            'notes' => 'nullable|string',
            'supporting_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
            'attendance_method' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceMethodOptions())),
            'supervisor_verification' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getSupervisorVerificationOptions())),
            'employee_shift_id' => 'nullable|exists:employee_shifts,id',
            'hrd_notes' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'device_info' => 'nullable|string|max:255',
            'time_logs' => 'nullable|array',
            'time_logs.*.time_in' => 'required_with:time_logs|date_format:H:i',
            'time_logs.*.time_out' => 'nullable|date_format:H:i|after:time_logs.*.time_in',
            'time_logs.*.notes' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attendance_documents', $filename, 'public');
            $validated['supporting_document'] = $path;
        }

        // Set additional fields
        $validated['attendance_input_date'] = now();
        $validated['data_updated_at'] = now();
        $validated['ip_address'] = $request->ip();

        // Process time logs if provided
        if (isset($validated['time_logs']) && is_array($validated['time_logs'])) {
            $timeLogs = [];
            foreach ($validated['time_logs'] as $log) {
                $timeLogs[] = [
                    'time_in' => $log['time_in'],
                    'time_out' => $log['time_out'] ?? null,
                    'notes' => $log['notes'] ?? null,
                    'created_at' => now()->toISOString(),
                ];
            }
            $validated['time_logs'] = $timeLogs;
        }

        $attendance = EmployeeAttendance::create($validated);

        return redirect()->route('employee-attendances.index')
            ->with('success', 'Data absensi karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->load(['employee', 'employeeShift']);
        return view('employee-attendances.show', compact('employeeAttendance'));
    }

    public function edit(EmployeeAttendance $employeeAttendance)
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $shifts = EmployeeShift::with('employee')
            ->where('shift_date', '>=', Carbon::today()->subDays(7))
            ->get();
        
        $attendanceStatuses = EmployeeAttendance::getAttendanceStatusOptions();
        $dayTypes = EmployeeAttendance::getDayTypeOptions();
        $workLocations = EmployeeAttendance::getWorkLocationOptions();
        $attendanceMethods = EmployeeAttendance::getAttendanceMethodOptions();
        $supervisorVerifications = EmployeeAttendance::getSupervisorVerificationOptions();
        
        return view('employee-attendances.edit', compact(
            'employeeAttendance',
            'employees',
            'shifts',
            'attendanceStatuses',
            'dayTypes',
            'workLocations',
            'attendanceMethods',
            'supervisorVerifications'
        ));
    }

    public function update(Request $request, EmployeeAttendance $employeeAttendance)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'attendance_date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'attendance_status' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceStatusOptions())),
            'day_type' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getDayTypeOptions())),
            'work_location' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getWorkLocationOptions())),
            'notes' => 'nullable|string',
            'supporting_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
            'attendance_method' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceMethodOptions())),
            'supervisor_verification' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getSupervisorVerificationOptions())),
            'employee_shift_id' => 'nullable|exists:employee_shifts,id',
            'hrd_notes' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'device_info' => 'nullable|string|max:255',
            'time_logs' => 'nullable|array',
            'time_logs.*.time_in' => 'required_with:time_logs|date_format:H:i',
            'time_logs.*.time_out' => 'nullable|date_format:H:i|after:time_logs.*.time_in',
            'time_logs.*.notes' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('supporting_document')) {
            // Delete old file if exists
            if ($employeeAttendance->supporting_document && Storage::disk('public')->exists($employeeAttendance->supporting_document)) {
                Storage::disk('public')->delete($employeeAttendance->supporting_document);
            }

            $file = $request->file('supporting_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attendance_documents', $filename, 'public');
            $validated['supporting_document'] = $path;
        }

        // Set additional fields
        $validated['data_updated_at'] = now();

        // Process time logs if provided
        if (isset($validated['time_logs']) && is_array($validated['time_logs'])) {
            $timeLogs = [];
            foreach ($validated['time_logs'] as $log) {
                $timeLogs[] = [
                    'time_in' => $log['time_in'],
                    'time_out' => $log['time_out'] ?? null,
                    'notes' => $log['notes'] ?? null,
                    'created_at' => now()->toISOString(),
                ];
            }
            $validated['time_logs'] = $timeLogs;
        }

        $employeeAttendance->update($validated);

        return redirect()->route('employee-attendances.index')
            ->with('success', 'Data absensi karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        // Delete file if exists
        if ($employeeAttendance->supporting_document && Storage::disk('public')->exists($employeeAttendance->supporting_document)) {
            Storage::disk('public')->delete($employeeAttendance->supporting_document);
        }

        $employeeAttendance->delete();

        return redirect()->route('employee-attendances.index')
            ->with('success', 'Data absensi karyawan berhasil dihapus.');
    }

    // Additional methods for attendance management
    public function getByEmployee(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->byEmployee($employeeId);

        if ($startDate && $endDate) {
            $query->byDateRange($startDate, $endDate);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();

        return response()->json($attendances);
    }

    public function getByDate(Request $request)
    {
        $date = $request->get('date');
        $attendances = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->byDate($date)
            ->orderBy('time_in')
            ->get();

        return response()->json($attendances);
    }

    public function getByDateRange(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $attendances = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->byDateRange($startDate, $endDate)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('time_in')
            ->get();

        return response()->json($attendances);
    }

    // Get employee data for AJAX
    public function getEmployeeData(Employee $employee)
    {
        return response()->json([
            'employee_name' => $employee->full_name,
            'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
            'work_unit' => $employee->workUnit->name ?? '',
            'position' => $employee->position->name ?? '',
        ]);
    }

    // Time-in/Time-out methods
    public function timeIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'work_location' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getWorkLocationOptions())),
            'attendance_method' => 'required|in:' . implode(',', array_keys(EmployeeAttendance::getAttendanceMethodOptions())),
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string',
        ]);

        $employee = Employee::find($validated['employee_id']);
        
        // Check if attendance already exists for this date
        $attendance = EmployeeAttendance::where('employee_id', $validated['employee_id'])
            ->where('attendance_date', $validated['attendance_date'])
            ->first();

        if ($attendance) {
            // Add new time log
            $attendance->addTimeLog($validated['time_in'], null, $validated['notes'] ?? null);
            $attendance->save();
        } else {
            // Create new attendance record
            $attendanceData = [
                'employee_id' => $validated['employee_id'],
                'employee_name' => $employee->full_name,
                'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
                'attendance_date' => $validated['attendance_date'],
                'time_in' => $validated['time_in'],
                'attendance_status' => 'hadir',
                'day_type' => $this->determineDayType($validated['attendance_date']),
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
            ];

            $attendance = EmployeeAttendance::create($attendanceData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Time-in berhasil dicatat',
            'attendance' => $attendance->load(['employee', 'employeeShift'])
        ]);
    }

    public function timeOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'time_out' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $attendance = EmployeeAttendance::where('employee_id', $validated['employee_id'])
            ->where('attendance_date', $validated['attendance_date'])
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan. Silakan time-in terlebih dahulu.'
            ], 404);
        }

        // Update the latest time log or main time_out
        if ($attendance->time_logs && count($attendance->time_logs) > 0) {
            $timeLogs = $attendance->time_logs;
            $lastIndex = count($timeLogs) - 1;
            
            if (!isset($timeLogs[$lastIndex]['time_out'])) {
                $timeLogs[$lastIndex]['time_out'] = $validated['time_out'];
                $timeLogs[$lastIndex]['notes'] = $validated['notes'] ?? $timeLogs[$lastIndex]['notes'];
                $timeLogs[$lastIndex]['updated_at'] = now()->toISOString();
                
                $attendance->time_logs = $timeLogs;
            } else {
                // Add new time log for time-out only
                $attendance->addTimeLog(null, $validated['time_out'], $validated['notes']);
            }
        } else {
            $attendance->time_out = $validated['time_out'];
        }

        $attendance->data_updated_at = now();
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Time-out berhasil dicatat',
            'attendance' => $attendance->load(['employee', 'employeeShift'])
        ]);
    }

    // Supervisor verification methods
    public function approve(EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->update([
            'supervisor_verification' => 'approved',
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Absensi berhasil disetujui.');
    }

    public function reject(Request $request, EmployeeAttendance $employeeAttendance)
    {
        $validated = $request->validate([
            'hrd_notes' => 'required|string|max:500',
        ]);

        $employeeAttendance->update([
            'supervisor_verification' => 'rejected',
            'hrd_notes' => $validated['hrd_notes'],
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Absensi berhasil ditolak.');
    }

    // Bulk operations
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'attendance_ids' => 'required|array',
            'attendance_ids.*' => 'exists:employee_attendances,id',
        ]);

        EmployeeAttendance::whereIn('id', $validated['attendance_ids'])
            ->update([
                'supervisor_verification' => 'approved',
                'data_updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Berhasil menyetujui ' . count($validated['attendance_ids']) . ' data absensi.');
    }

    // Download supporting document
    public function downloadDocument(EmployeeAttendance $employeeAttendance)
    {
        if (!$employeeAttendance->has_supporting_document) {
            return redirect()->back()
                ->with('error', 'Dokumen pendukung tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $employeeAttendance->supporting_document);
        
        if (!file_exists($filePath)) {
            return redirect()->back()
                ->with('error', 'File dokumen tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    // Generate attendance report
    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'employee_id' => 'nullable|exists:employees,id',
            'attendance_status' => 'nullable|string',
            'work_location' => 'nullable|string',
        ]);

        $query = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->byDateRange($validated['start_date'], $validated['end_date']);

        if ($validated['employee_id'] ?? false) {
            $query->byEmployee($validated['employee_id']);
        }

        if ($validated['attendance_status'] ?? false) {
            $query->byStatus($validated['attendance_status']);
        }

        if ($validated['work_location'] ?? false) {
            $query->byWorkLocation($validated['work_location']);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')
                           ->orderBy('time_in')
                           ->get();
        
        $statistics = EmployeeAttendance::getAttendanceStatistics(
            $validated['employee_id'] ?? null,
            $validated['start_date'],
            $validated['end_date']
        );

        return response()->json([
            'attendances' => $attendances,
            'statistics' => $statistics,
            'period' => [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ],
            'filters' => [
                'employee_id' => $validated['employee_id'] ?? null,
                'attendance_status' => $validated['attendance_status'] ?? null,
                'work_location' => $validated['work_location'] ?? null,
            ],
        ]);
    }

    // Get attendance statistics
    public function getStatistics(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $statistics = EmployeeAttendance::getAttendanceStatistics($employeeId, $startDate, $endDate);

        return response()->json($statistics);
    }

    // Get monthly attendance
    public function getMonthlyAttendance(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'year' => 'required|integer|min:2020|max:2030',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $attendances = EmployeeAttendance::getMonthlyAttendance(
            $validated['employee_id'],
            $validated['year'],
            $validated['month']
        );

        return response()->json($attendances);
    }

    // Helper method to determine day type
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

    // Get today's attendance for dashboard
    public function getTodayAttendance()
    {
        $attendances = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->today()
            ->orderBy('time_in')
            ->get();

        return response()->json($attendances);
    }

    // Get pending verifications
    public function getPendingVerifications()
    {
        $attendances = EmployeeAttendance::with(['employee', 'employeeShift'])
            ->pendingVerification()
            ->orderBy('attendance_date', 'desc')
            ->get();

        return response()->json($attendances);
    }
}
