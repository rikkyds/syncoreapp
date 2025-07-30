<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeLeaveController extends Controller
{
    public function index()
    {
        $leaves = EmployeeLeave::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('employee-leaves.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'full_name', 'employee_id', 'nik')->get();
        $leaveTypes = EmployeeLeave::getLeaveTypes();
        $statusOptions = EmployeeLeave::getStatusOptions();
        
        return view('employee-leaves.create', compact('employees', 'leaveTypes', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'full_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'leave_type' => 'required|in:annual,sick,maternity,paternity,special,unpaid,emergency',
            'application_date' => 'required|date',
            'start_date' => 'required|date|after_or_equal:application_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,approved,rejected',
            'supervisor_name' => 'required|string|max:255',
            'remaining_leave_balance' => 'nullable|integer|min:0',
            'leave_reason' => 'nullable|string',
            'return_to_work_date' => 'nullable|date|after:end_date',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Calculate duration in days
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Handle file upload
        if ($request->hasFile('supporting_document')) {
            $validated['supporting_document'] = $request->file('supporting_document')
                ->store('employee-leaves/documents', 'public');
        }

        // Set data_updated_at
        $validated['data_updated_at'] = now();

        EmployeeLeave::create($validated);

        return redirect()->route('employee-leaves.index')
            ->with('success', 'Data cuti karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeLeave $employeeLeave)
    {
        $employeeLeave->load('employee');
        return view('employee-leaves.show', compact('employeeLeave'));
    }

    public function edit(EmployeeLeave $employeeLeave)
    {
        $employees = Employee::select('id', 'full_name', 'employee_id', 'nik')->get();
        $leaveTypes = EmployeeLeave::getLeaveTypes();
        $statusOptions = EmployeeLeave::getStatusOptions();
        
        return view('employee-leaves.edit', compact('employeeLeave', 'employees', 'leaveTypes', 'statusOptions'));
    }

    public function update(Request $request, EmployeeLeave $employeeLeave)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'full_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'leave_type' => 'required|in:annual,sick,maternity,paternity,special,unpaid,emergency',
            'application_date' => 'required|date',
            'start_date' => 'required|date|after_or_equal:application_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,approved,rejected',
            'supervisor_name' => 'required|string|max:255',
            'remaining_leave_balance' => 'nullable|integer|min:0',
            'leave_reason' => 'nullable|string',
            'return_to_work_date' => 'nullable|date|after:end_date',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Calculate duration in days
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Handle file upload
        if ($request->hasFile('supporting_document')) {
            // Delete old file if exists
            if ($employeeLeave->supporting_document) {
                Storage::disk('public')->delete($employeeLeave->supporting_document);
            }
            
            $validated['supporting_document'] = $request->file('supporting_document')
                ->store('employee-leaves/documents', 'public');
        }

        // Set data_updated_at
        $validated['data_updated_at'] = now();

        $employeeLeave->update($validated);

        return redirect()->route('employee-leaves.index')
            ->with('success', 'Data cuti karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeLeave $employeeLeave)
    {
        // Delete associated file
        if ($employeeLeave->supporting_document) {
            Storage::disk('public')->delete($employeeLeave->supporting_document);
        }

        $employeeLeave->delete();

        return redirect()->route('employee-leaves.index')
            ->with('success', 'Data cuti karyawan berhasil dihapus.');
    }

    // Additional methods for specific actions
    public function approve(EmployeeLeave $employeeLeave)
    {
        $employeeLeave->update([
            'status' => 'approved',
            'data_updated_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Cuti karyawan berhasil disetujui.');
    }

    public function reject(EmployeeLeave $employeeLeave)
    {
        $employeeLeave->update([
            'status' => 'rejected',
            'data_updated_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Cuti karyawan berhasil ditolak.');
    }

    // Get employee data for AJAX
    public function getEmployeeData(Employee $employee)
    {
        return response()->json([
            'full_name' => $employee->full_name,
            'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
        ]);
    }
}
