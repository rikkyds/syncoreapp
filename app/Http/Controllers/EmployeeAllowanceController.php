<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAllowance;
use App\Models\WorkUnit;
use App\Models\Position;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeAllowanceController extends Controller
{
    public function index()
    {
        $allowances = EmployeeAllowance::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('employee-allowances.index', compact('allowances'));
    }

    public function create()
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $allowanceTypes = EmployeeAllowance::getAllowanceTypeOptions();
        $paymentFrequencies = EmployeeAllowance::getPaymentFrequencyOptions();
        $allowanceStatuses = EmployeeAllowance::getAllowanceStatusOptions();
        $paymentMethods = EmployeeAllowance::getPaymentMethodOptions();
        $workUnits = WorkUnit::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        
        return view('employee-allowances.create', compact(
            'employees',
            'allowanceTypes',
            'paymentFrequencies',
            'allowanceStatuses',
            'paymentMethods',
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
            'work_unit' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'allowance_type' => 'required|in:tunjangan_tetap,tunjangan_tidak_tetap,tunjangan_transportasi,tunjangan_makan,tunjangan_kesehatan,tunjangan_anak,tunjangan_jabatan,tunjangan_kinerja,tunjangan_lembur,tunjangan_khusus',
            'allowance_amount' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:bulanan,mingguan,sekali,tahunan,per_proyek,harian,per_kehadiran',
            'allowance_status' => 'required|in:aktif,tidak_aktif,ditangguhkan,sementara',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'terms_conditions' => 'nullable|string',
            'payment_method' => 'required|in:bersamaan_gaji,terpisah,reimburse,transfer_langsung,tunai',
        ]);

        $validated['data_updated_at'] = now();

        EmployeeAllowance::create($validated);

        return redirect()->route('employee-allowances.index')
            ->with('success', 'Data tunjangan karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeAllowance $employeeAllowance)
    {
        $employeeAllowance->load('employee');
        return view('employee-allowances.show', compact('employeeAllowance'));
    }

    public function edit(EmployeeAllowance $employeeAllowance)
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $allowanceTypes = EmployeeAllowance::getAllowanceTypeOptions();
        $paymentFrequencies = EmployeeAllowance::getPaymentFrequencyOptions();
        $allowanceStatuses = EmployeeAllowance::getAllowanceStatusOptions();
        $paymentMethods = EmployeeAllowance::getPaymentMethodOptions();
        $workUnits = WorkUnit::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        
        return view('employee-allowances.edit', compact(
            'employeeAllowance',
            'employees',
            'allowanceTypes',
            'paymentFrequencies',
            'allowanceStatuses',
            'paymentMethods',
            'workUnits',
            'positions'
        ));
    }

    public function update(Request $request, EmployeeAllowance $employeeAllowance)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'work_unit' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'allowance_type' => 'required|in:tunjangan_tetap,tunjangan_tidak_tetap,tunjangan_transportasi,tunjangan_makan,tunjangan_kesehatan,tunjangan_anak,tunjangan_jabatan,tunjangan_kinerja,tunjangan_lembur,tunjangan_khusus',
            'allowance_amount' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:bulanan,mingguan,sekali,tahunan,per_proyek,harian,per_kehadiran',
            'allowance_status' => 'required|in:aktif,tidak_aktif,ditangguhkan,sementara',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'terms_conditions' => 'nullable|string',
            'payment_method' => 'required|in:bersamaan_gaji,terpisah,reimburse,transfer_langsung,tunai',
        ]);

        $validated['data_updated_at'] = now();

        $employeeAllowance->update($validated);

        return redirect()->route('employee-allowances.index')
            ->with('success', 'Data tunjangan karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeAllowance $employeeAllowance)
    {
        $employeeAllowance->delete();

        return redirect()->route('employee-allowances.index')
            ->with('success', 'Data tunjangan karyawan berhasil dihapus.');
    }

    // Additional methods for filtering and reporting
    public function getByEmployee(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $allowances = EmployeeAllowance::with('employee')
            ->byEmployee($employeeId)
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json($allowances);
    }

    public function getByType(Request $request)
    {
        $type = $request->get('type');
        $allowances = EmployeeAllowance::with('employee')
            ->byAllowanceType($type)
            ->active()
            ->orderBy('allowance_amount', 'desc')
            ->get();

        return response()->json($allowances);
    }

    public function getActiveAllowances()
    {
        $allowances = EmployeeAllowance::with('employee')
            ->active()
            ->orderBy('allowance_amount', 'desc')
            ->get();

        return response()->json($allowances);
    }

    public function getExpiredAllowances()
    {
        $allowances = EmployeeAllowance::with('employee')
            ->expired()
            ->orderBy('end_date', 'desc')
            ->get();

        return response()->json($allowances);
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

    // Activate/Deactivate allowance
    public function activate(EmployeeAllowance $employeeAllowance)
    {
        $employeeAllowance->update([
            'allowance_status' => 'aktif',
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Tunjangan berhasil diaktifkan.');
    }

    public function deactivate(EmployeeAllowance $employeeAllowance)
    {
        $employeeAllowance->update([
            'allowance_status' => 'tidak_aktif',
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Tunjangan berhasil dinonaktifkan.');
    }

    // Bulk operations
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'allowance_ids' => 'required|array',
            'allowance_ids.*' => 'exists:employee_allowances,id',
            'status' => 'required|in:aktif,tidak_aktif,ditangguhkan,sementara',
        ]);

        EmployeeAllowance::whereIn('id', $validated['allowance_ids'])
            ->update([
                'allowance_status' => $validated['status'],
                'data_updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Status tunjangan untuk ' . count($validated['allowance_ids']) . ' karyawan berhasil diperbarui.');
    }

    // Calculate total allowances for a period
    public function calculateTotalAllowances(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'employee_id' => 'nullable|exists:employees,id',
            'allowance_type' => 'nullable|string',
            'work_unit' => 'nullable|string',
        ]);

        $query = EmployeeAllowance::active();

        if ($validated['employee_id'] ?? false) {
            $query->byEmployee($validated['employee_id']);
        }

        if ($validated['allowance_type'] ?? false) {
            $query->byAllowanceType($validated['allowance_type']);
        }

        if ($validated['work_unit'] ?? false) {
            $query->byWorkUnit($validated['work_unit']);
        }

        $allowances = $query->get();
        $total = 0;

        foreach ($allowances as $allowance) {
            $total += $allowance->calculateTotalForPeriod(
                $validated['start_date'],
                $validated['end_date']
            );
        }

        return response()->json([
            'total_allowances' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
            'period' => [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ],
            'filters' => [
                'employee_id' => $validated['employee_id'] ?? null,
                'allowance_type' => $validated['allowance_type'] ?? null,
                'work_unit' => $validated['work_unit'] ?? null,
            ],
            'allowances_count' => $allowances->count(),
        ]);
    }
}
