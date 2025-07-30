<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['company', 'branchOffice', 'workUnit', 'position'])
            ->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        $workUnits = WorkUnit::all();
        return view('employees.create', compact('positions', 'workUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|unique:employees',
            'ktp_photo' => 'nullable|image|max:2048',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'personal_email' => 'required|email',
            
            'bpjs_health' => 'nullable|string',
            'bpjs_health_photo' => 'nullable|image|max:2048',
            'bpjs_employment' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'npwp' => 'nullable|string',
            'npwp_photo' => 'nullable|image|max:2048',
            
            'employee_id' => 'required|string|unique:employees',
            'work_unit_id' => 'required|exists:work_units,id',
            'position_id' => 'required|exists:positions,id',
            'employment_status' => 'required|in:permanent,contract,probation,intern',
            'join_date' => 'required|date',
            
            'company_id' => 'required|exists:companies,id',
            'branch_office_id' => 'required|exists:branch_offices,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('ktp_photo')) {
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('employees/ktp', 'public');
        }
        if ($request->hasFile('bpjs_health_photo')) {
            $validated['bpjs_health_photo'] = $request->file('bpjs_health_photo')->store('employees/bpjs', 'public');
        }
        if ($request->hasFile('npwp_photo')) {
            $validated['npwp_photo'] = $request->file('npwp_photo')->store('employees/npwp', 'public');
        }

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $workUnits = WorkUnit::all();
        return view('employees.edit', compact('employee', 'positions', 'workUnits'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => ['required', 'string', Rule::unique('employees')->ignore($employee->id)],
            'ktp_photo' => 'nullable|image|max:2048',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'personal_email' => 'required|email',
            
            'bpjs_health' => 'nullable|string',
            'bpjs_health_photo' => 'nullable|image|max:2048',
            'bpjs_employment' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'npwp' => 'nullable|string',
            'npwp_photo' => 'nullable|image|max:2048',
            
            'employee_id' => ['required', 'string', Rule::unique('employees')->ignore($employee->id)],
            'work_unit_id' => 'required|exists:work_units,id',
            'position_id' => 'required|exists:positions,id',
            'employment_status' => 'required|in:permanent,contract,probation,intern',
            'join_date' => 'required|date',
            
            'company_id' => 'required|exists:companies,id',
            'branch_office_id' => 'required|exists:branch_offices,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('ktp_photo')) {
            if ($employee->ktp_photo) {
                Storage::disk('public')->delete($employee->ktp_photo);
            }
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('employees/ktp', 'public');
        }
        if ($request->hasFile('bpjs_health_photo')) {
            if ($employee->bpjs_health_photo) {
                Storage::disk('public')->delete($employee->bpjs_health_photo);
            }
            $validated['bpjs_health_photo'] = $request->file('bpjs_health_photo')->store('employees/bpjs', 'public');
        }
        if ($request->hasFile('npwp_photo')) {
            if ($employee->npwp_photo) {
                Storage::disk('public')->delete($employee->npwp_photo);
            }
            $validated['npwp_photo'] = $request->file('npwp_photo')->store('employees/npwp', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Delete associated files
        if ($employee->ktp_photo) {
            Storage::disk('public')->delete($employee->ktp_photo);
        }
        if ($employee->bpjs_health_photo) {
            Storage::disk('public')->delete($employee->bpjs_health_photo);
        }
        if ($employee->npwp_photo) {
            Storage::disk('public')->delete($employee->npwp_photo);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
