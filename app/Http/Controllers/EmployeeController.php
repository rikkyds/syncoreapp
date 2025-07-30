<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\WorkUnit;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\BranchOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        $companies = Company::all();
        $branchOffices = BranchOffice::all();
        return view('employees.create', compact('positions', 'workUnits', 'companies', 'branchOffices'));
    }

    /**
     * Show quick create form for minimal employee data
     */
    public function quickCreate()
    {
        $defaultRole = Role::where('name', 'karyawan')->first();
        return view('employees.quick-create', compact('defaultRole'));
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

    /**
     * Store quick employee with minimal data and auto-create user account
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'personal_email' => 'required|email|unique:users,email|unique:employees,personal_email',
        ]);

        DB::beginTransaction();
        
        try {
            // Generate employee ID
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $nextId = $lastEmployee ? $lastEmployee->id + 1 : 1;
            $employeeId = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            // Get default role (karyawan)
            $defaultRole = Role::where('name', 'karyawan')->first();
            if (!$defaultRole) {
                throw new \Exception('Default role "karyawan" not found');
            }

            // Create user account first
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['personal_email'],
                'password' => Hash::make('syncore123'),
                'role_id' => $defaultRole->id,
                'email_verified_at' => now(),
            ]);

            // Get default values for required foreign keys
            $defaultCompany = Company::first();
            $defaultBranchOffice = BranchOffice::first();
            $defaultWorkUnit = WorkUnit::first();
            $defaultPosition = Position::first();
            
            // Create default position if none exists
            if (!$defaultPosition) {
                $defaultPosition = Position::create([
                    'name' => 'Staff',
                    'description' => 'Default Staff Position'
                ]);
            }

            // Create employee with minimal data
            $employee = Employee::create([
                'full_name' => $validated['full_name'],
                'phone_number' => $validated['phone_number'],
                'personal_email' => $validated['personal_email'],
                'employee_id' => $employeeId,
                'user_id' => $user->id,
                
                // Set default/placeholder values for required fields
                'nik' => 'TEMP-' . time(),
                'birth_place' => 'Belum diisi',
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'marital_status' => 'single',
                'address' => 'Belum diisi',
                'employment_status' => 'probation',
                'join_date' => now()->toDateString(),
                
                // Use default values for required foreign keys
                'company_id' => $defaultCompany->id,
                'branch_office_id' => $defaultBranchOffice->id,
                'work_unit_id' => $defaultWorkUnit->id,
                'position_id' => $defaultPosition->id,
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Karyawan berhasil dibuat! Email: ' . $validated['personal_email'] . ', Password: syncore123. Data lengkap dapat diperbarui nanti.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
