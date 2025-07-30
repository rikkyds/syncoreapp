<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\WorkUnit;
use App\Models\Position;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeSalaryController extends Controller
{
    public function index()
    {
        $salaries = EmployeeSalary::with('employee')
            ->orderBy('salary_date', 'desc')
            ->paginate(10);
        
        return view('employee-salaries.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id', 'employment_status')
            ->get();
        
        $employeeStatuses = EmployeeSalary::getEmployeeStatusOptions();
        $paymentMethods = EmployeeSalary::getPaymentMethodOptions();
        $paymentStatuses = EmployeeSalary::getPaymentStatusOptions();
        $workUnits = WorkUnit::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        
        return view('employee-salaries.create', compact(
            'employees',
            'employeeStatuses',
            'paymentMethods',
            'paymentStatuses',
            'workUnits',
            'positions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'work_unit' => 'required|string|max:255',
            'employee_status' => 'required|in:tetap,kontrak,magang,lepas,paruh_waktu,freelance',
            'salary_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'fixed_allowances' => 'nullable|numeric|min:0',
            'variable_allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:transfer_bank,tunai,e_wallet,cek,giro',
            'account_number' => 'nullable|string|max:255',
            'payment_status' => 'required|in:sudah_dibayar,belum_dibayar,gagal_bayar,pending,dibatalkan',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Set defaults for nullable fields
        $validated['fixed_allowances'] = $validated['fixed_allowances'] ?? 0;
        $validated['variable_allowances'] = $validated['variable_allowances'] ?? 0;
        $validated['deductions'] = $validated['deductions'] ?? 0;

        // Auto-generate salary period
        $validated['salary_period'] = Carbon::parse($validated['salary_date'])->locale('id')->isoFormat('MMMM YYYY');
        
        // Auto-calculate net salary (will be recalculated in model boot method)
        $gross = $validated['basic_salary'] + $validated['fixed_allowances'] + $validated['variable_allowances'];
        $validated['net_salary'] = $gross - $validated['deductions'];

        $validated['data_updated_at'] = now();

        EmployeeSalary::create($validated);

        return redirect()->route('employee-salaries.index')
            ->with('success', 'Data gaji karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->load('employee');
        return view('employee-salaries.show', compact('employeeSalary'));
    }

    public function edit(EmployeeSalary $employeeSalary)
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id', 'employment_status')
            ->get();
        
        $employeeStatuses = EmployeeSalary::getEmployeeStatusOptions();
        $paymentMethods = EmployeeSalary::getPaymentMethodOptions();
        $paymentStatuses = EmployeeSalary::getPaymentStatusOptions();
        $workUnits = WorkUnit::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        
        return view('employee-salaries.edit', compact(
            'employeeSalary',
            'employees',
            'employeeStatuses',
            'paymentMethods',
            'paymentStatuses',
            'workUnits',
            'positions'
        ));
    }

    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'work_unit' => 'required|string|max:255',
            'employee_status' => 'required|in:tetap,kontrak,magang,lepas,paruh_waktu,freelance',
            'salary_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'fixed_allowances' => 'nullable|numeric|min:0',
            'variable_allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:transfer_bank,tunai,e_wallet,cek,giro',
            'account_number' => 'nullable|string|max:255',
            'payment_status' => 'required|in:sudah_dibayar,belum_dibayar,gagal_bayar,pending,dibatalkan',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Set defaults for nullable fields
        $validated['fixed_allowances'] = $validated['fixed_allowances'] ?? 0;
        $validated['variable_allowances'] = $validated['variable_allowances'] ?? 0;
        $validated['deductions'] = $validated['deductions'] ?? 0;

        // Auto-generate salary period
        $validated['salary_period'] = Carbon::parse($validated['salary_date'])->locale('id')->isoFormat('MMMM YYYY');
        
        // Auto-calculate net salary (will be recalculated in model boot method)
        $gross = $validated['basic_salary'] + $validated['fixed_allowances'] + $validated['variable_allowances'];
        $validated['net_salary'] = $gross - $validated['deductions'];

        $validated['data_updated_at'] = now();

        $employeeSalary->update($validated);

        return redirect()->route('employee-salaries.index')
            ->with('success', 'Data gaji karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->delete();

        return redirect()->route('employee-salaries.index')
            ->with('success', 'Data gaji karyawan berhasil dihapus.');
    }

    // Additional methods for filtering and reporting
    public function getByEmployee(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $salaries = EmployeeSalary::with('employee')
            ->byEmployee($employeeId)
            ->orderBy('salary_date', 'desc')
            ->get();

        return response()->json($salaries);
    }

    public function getByPeriod(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $salaries = EmployeeSalary::with('employee')
            ->byPeriod($startDate, $endDate)
            ->orderBy('salary_date', 'desc')
            ->get();

        return response()->json($salaries);
    }

    public function getPaidSalaries()
    {
        $salaries = EmployeeSalary::with('employee')
            ->paid()
            ->orderBy('payment_date', 'desc')
            ->get();

        return response()->json($salaries);
    }

    public function getUnpaidSalaries()
    {
        $salaries = EmployeeSalary::with('employee')
            ->unpaid()
            ->orderBy('salary_date', 'desc')
            ->get();

        return response()->json($salaries);
    }

    public function getOverdueSalaries()
    {
        $salaries = EmployeeSalary::with('employee')
            ->overdue()
            ->orderBy('salary_date', 'desc')
            ->get();

        return response()->json($salaries);
    }

    // Get employee data for AJAX
    public function getEmployeeData(Employee $employee)
    {
        return response()->json([
            'employee_name' => $employee->full_name,
            'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
            'position' => $employee->position->name ?? '',
            'work_unit' => $employee->workUnit->name ?? '',
            'employee_status' => $employee->employment_status ?? 'tetap',
        ]);
    }

    // Mark salary as paid
    public function markAsPaid(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->update([
            'payment_status' => 'sudah_dibayar',
            'payment_date' => now()->toDateString(),
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Gaji berhasil ditandai sebagai sudah dibayar.');
    }

    // Mark salary as unpaid
    public function markAsUnpaid(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->update([
            'payment_status' => 'belum_dibayar',
            'payment_date' => null,
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Status gaji berhasil diubah menjadi belum dibayar.');
    }

    // Bulk operations
    public function bulkUpdatePaymentStatus(Request $request)
    {
        $validated = $request->validate([
            'salary_ids' => 'required|array',
            'salary_ids.*' => 'exists:employee_salaries,id',
            'payment_status' => 'required|in:sudah_dibayar,belum_dibayar,gagal_bayar,pending,dibatalkan',
        ]);

        $updateData = [
            'payment_status' => $validated['payment_status'],
            'data_updated_at' => now(),
        ];

        // If marking as paid, set payment date
        if ($validated['payment_status'] === 'sudah_dibayar') {
            $updateData['payment_date'] = now()->toDateString();
        } elseif ($validated['payment_status'] === 'belum_dibayar') {
            $updateData['payment_date'] = null;
        }

        EmployeeSalary::whereIn('id', $validated['salary_ids'])
            ->update($updateData);

        return redirect()->back()
            ->with('success', 'Status pembayaran untuk ' . count($validated['salary_ids']) . ' gaji berhasil diperbarui.');
    }

    // Generate salary report
    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'work_unit' => 'nullable|string',
            'employee_status' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        $query = EmployeeSalary::with('employee')
            ->byPeriod($validated['start_date'], $validated['end_date']);

        if ($validated['work_unit'] ?? false) {
            $query->byWorkUnit($validated['work_unit']);
        }

        if ($validated['employee_status'] ?? false) {
            $query->byEmployeeStatus($validated['employee_status']);
        }

        if ($validated['payment_status'] ?? false) {
            $query->byPaymentStatus($validated['payment_status']);
        }

        $salaries = $query->orderBy('salary_date', 'desc')->get();
        
        $statistics = [
            'total_employees' => $salaries->unique('employee_id')->count(),
            'total_gross_salary' => $salaries->sum('gross_salary'),
            'total_deductions' => $salaries->sum('deductions'),
            'total_net_salary' => $salaries->sum('net_salary'),
            'paid_count' => $salaries->where('payment_status', 'sudah_dibayar')->count(),
            'unpaid_count' => $salaries->where('payment_status', 'belum_dibayar')->count(),
            'overdue_count' => $salaries->filter(function($salary) {
                return $salary->is_overdue;
            })->count(),
        ];

        return response()->json([
            'salaries' => $salaries,
            'statistics' => $statistics,
            'period' => [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ],
            'filters' => [
                'work_unit' => $validated['work_unit'] ?? null,
                'employee_status' => $validated['employee_status'] ?? null,
                'payment_status' => $validated['payment_status'] ?? null,
            ],
        ]);
    }

    // Get salary statistics
    public function getStatistics(Request $request)
    {
        $period = $request->get('period'); // Format: YYYY-MM
        $statistics = EmployeeSalary::getSalaryStatistics($period);

        return response()->json($statistics);
    }

    // Duplicate salary for next period
    public function duplicateForNextPeriod(EmployeeSalary $employeeSalary)
    {
        $nextMonth = Carbon::parse($employeeSalary->salary_date)->addMonth();
        
        // Check if salary already exists for next period
        $existingSalary = EmployeeSalary::where('employee_id', $employeeSalary->employee_id)
            ->where('salary_date', $nextMonth->toDateString())
            ->first();

        if ($existingSalary) {
            return redirect()->back()
                ->with('error', 'Gaji untuk periode ' . $nextMonth->locale('id')->isoFormat('MMMM YYYY') . ' sudah ada.');
        }

        $newSalary = $employeeSalary->replicate();
        $newSalary->salary_date = $nextMonth->toDateString();
        $newSalary->salary_period = $nextMonth->locale('id')->isoFormat('MMMM YYYY');
        $newSalary->payment_status = 'belum_dibayar';
        $newSalary->payment_date = null;
        $newSalary->notes = null;
        $newSalary->data_updated_at = now();
        $newSalary->save();

        return redirect()->back()
            ->with('success', 'Gaji berhasil diduplikasi untuk periode ' . $nextMonth->locale('id')->isoFormat('MMMM YYYY') . '.');
    }
}
