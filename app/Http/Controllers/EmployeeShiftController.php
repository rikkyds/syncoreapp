<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\BranchOffice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeShiftController extends Controller
{
    public function index()
    {
        $shifts = EmployeeShift::with('employee')
            ->orderBy('shift_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(10);
        
        return view('employee-shifts.index', compact('shifts'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'full_name', 'employee_id', 'nik')->get();
        $shiftNames = EmployeeShift::getShiftNameOptions();
        $attendanceStatuses = EmployeeShift::getAttendanceStatusOptions();
        $workDayTypes = EmployeeShift::getWorkDayTypeOptions();
        $workLocations = BranchOffice::select('id', 'name')->get();
        
        return view('employee-shifts.create', compact(
            'employees', 
            'shiftNames', 
            'attendanceStatuses', 
            'workDayTypes',
            'workLocations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'shift_date' => 'required|date',
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'work_location' => 'required|string|max:255',
            'attendance_status' => 'required|in:hadir,izin,sakit,alpha,terlambat,pulang_cepat',
            'work_day_type' => 'required|in:hari_biasa,akhir_pekan,hari_libur,lembur,hari_khusus',
            'supervisor_name' => 'required|string|max:255',
            'shift_notes' => 'nullable|string',
        ]);

        // Calculate shift duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        
        // Handle overnight shifts
        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }
        
        $validated['shift_duration'] = $startTime->diffInHours($endTime, true);
        $validated['data_updated_at'] = now();

        EmployeeShift::create($validated);

        return redirect()->route('employee-shifts.index')
            ->with('success', 'Data shift karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeShift $employeeShift)
    {
        $employeeShift->load('employee');
        return view('employee-shifts.show', compact('employeeShift'));
    }

    public function edit(EmployeeShift $employeeShift)
    {
        $employees = Employee::select('id', 'full_name', 'employee_id', 'nik')->get();
        $shiftNames = EmployeeShift::getShiftNameOptions();
        $attendanceStatuses = EmployeeShift::getAttendanceStatusOptions();
        $workDayTypes = EmployeeShift::getWorkDayTypeOptions();
        $workLocations = BranchOffice::select('id', 'name')->get();
        
        return view('employee-shifts.edit', compact(
            'employeeShift',
            'employees', 
            'shiftNames', 
            'attendanceStatuses', 
            'workDayTypes',
            'workLocations'
        ));
    }

    public function update(Request $request, EmployeeShift $employeeShift)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'shift_date' => 'required|date',
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'work_location' => 'required|string|max:255',
            'attendance_status' => 'required|in:hadir,izin,sakit,alpha,terlambat,pulang_cepat',
            'work_day_type' => 'required|in:hari_biasa,akhir_pekan,hari_libur,lembur,hari_khusus',
            'supervisor_name' => 'required|string|max:255',
            'shift_notes' => 'nullable|string',
        ]);

        // Calculate shift duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        
        // Handle overnight shifts
        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }
        
        $validated['shift_duration'] = $startTime->diffInHours($endTime, true);
        $validated['data_updated_at'] = now();

        $employeeShift->update($validated);

        return redirect()->route('employee-shifts.index')
            ->with('success', 'Data shift karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeShift $employeeShift)
    {
        $employeeShift->delete();

        return redirect()->route('employee-shifts.index')
            ->with('success', 'Data shift karyawan berhasil dihapus.');
    }

    // Additional methods for filtering and reporting
    public function getByDate(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $shifts = EmployeeShift::with('employee')
            ->byDate($date)
            ->orderBy('start_time')
            ->get();

        return response()->json($shifts);
    }

    public function getByEmployee(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $shifts = EmployeeShift::with('employee')
            ->byEmployee($employeeId)
            ->whereBetween('shift_date', [$startDate, $endDate])
            ->orderBy('shift_date')
            ->get();

        return response()->json($shifts);
    }

    // Get employee data for AJAX
    public function getEmployeeData(Employee $employee)
    {
        return response()->json([
            'employee_name' => $employee->full_name,
            'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
            'work_location' => $employee->branchOffice->name ?? '',
        ]);
    }

    // Bulk operations
    public function bulkCreate(Request $request)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'shift_date' => 'required|date',
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'work_location' => 'required|string|max:255',
            'attendance_status' => 'required|in:hadir,izin,sakit,alpha,terlambat,pulang_cepat',
            'work_day_type' => 'required|in:hari_biasa,akhir_pekan,hari_libur,lembur,hari_khusus',
            'supervisor_name' => 'required|string|max:255',
            'shift_notes' => 'nullable|string',
        ]);

        // Calculate shift duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        
        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }
        
        $shiftDuration = $startTime->diffInHours($endTime, true);

        $employees = Employee::whereIn('id', $validated['employee_ids'])->get();
        
        foreach ($employees as $employee) {
            EmployeeShift::create([
                'employee_id' => $employee->id,
                'employee_name' => $employee->full_name,
                'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
                'shift_date' => $validated['shift_date'],
                'shift_name' => $validated['shift_name'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'shift_duration' => $shiftDuration,
                'work_location' => $validated['work_location'],
                'attendance_status' => $validated['attendance_status'],
                'work_day_type' => $validated['work_day_type'],
                'supervisor_name' => $validated['supervisor_name'],
                'shift_notes' => $validated['shift_notes'],
                'data_updated_at' => now(),
            ]);
        }

        return redirect()->route('employee-shifts.index')
            ->with('success', 'Shift untuk ' . count($employees) . ' karyawan berhasil ditambahkan.');
    }
}
