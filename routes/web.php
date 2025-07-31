<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BranchOfficeController;
use App\Http\Controllers\WorkUnitController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\EmployeeShiftController;
use App\Http\Controllers\EmployeeAllowanceController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SikojaController;
use App\Http\Controllers\SupportRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        });
        
        // User Management Routes
        Route::resource('users', UserController::class);
        
        // Role Management Routes
        Route::resource('roles', RoleController::class);

        // Master Data Routes
        Route::resource('companies', CompanyController::class);
        Route::resource('branch-offices', BranchOfficeController::class);
        Route::resource('work-units', WorkUnitController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('employees', EmployeeController::class);
        Route::get('employees-quick-create', [EmployeeController::class, 'quickCreate'])->name('employees.quick-create');
        Route::post('employees-quick-store', [EmployeeController::class, 'quickStore'])->name('employees.quick-store');
        Route::resource('employees.education', EducationController::class)->except(['index', 'show']);
        Route::resource('employees.skills', SkillController::class)->except(['index', 'show']);
        Route::resource('employees.work-experiences', WorkExperienceController::class)->except(['index', 'show']);
        Route::resource('employees.family-members', FamilyMemberController::class)->except(['index', 'show']);
        
        // Employee Leave Routes
        Route::resource('employee-leaves', EmployeeLeaveController::class);
        Route::patch('employee-leaves/{employeeLeave}/approve', [EmployeeLeaveController::class, 'approve'])->name('employee-leaves.approve');
        Route::patch('employee-leaves/{employeeLeave}/reject', [EmployeeLeaveController::class, 'reject'])->name('employee-leaves.reject');
        Route::get('employees/{employee}/data', [EmployeeLeaveController::class, 'getEmployeeData'])->name('employees.data');
        
        // Employee Shift Routes
        Route::resource('employee-shifts', EmployeeShiftController::class);
        Route::get('employee-shifts/date/{date}', [EmployeeShiftController::class, 'getByDate'])->name('employee-shifts.by-date');
        Route::get('employee-shifts/employee/{employee}', [EmployeeShiftController::class, 'getByEmployee'])->name('employee-shifts.by-employee');
        Route::get('employees/{employee}/shift-data', [EmployeeShiftController::class, 'getEmployeeData'])->name('employees.shift-data');
        Route::post('employee-shifts/bulk-create', [EmployeeShiftController::class, 'bulkCreate'])->name('employee-shifts.bulk-create');
        
        // Employee Allowance Routes
        Route::resource('employee-allowances', EmployeeAllowanceController::class);
        Route::get('employee-allowances/employee/{employee}', [EmployeeAllowanceController::class, 'getByEmployee'])->name('employee-allowances.by-employee');
        Route::get('employee-allowances/type/{type}', [EmployeeAllowanceController::class, 'getByType'])->name('employee-allowances.by-type');
        Route::get('employee-allowances-active', [EmployeeAllowanceController::class, 'getActiveAllowances'])->name('employee-allowances.active');
        Route::get('employee-allowances-expired', [EmployeeAllowanceController::class, 'getExpiredAllowances'])->name('employee-allowances.expired');
        Route::get('employees/{employee}/allowance-data', [EmployeeAllowanceController::class, 'getEmployeeData'])->name('employees.allowance-data');
        Route::patch('employee-allowances/{employeeAllowance}/activate', [EmployeeAllowanceController::class, 'activate'])->name('employee-allowances.activate');
        Route::patch('employee-allowances/{employeeAllowance}/deactivate', [EmployeeAllowanceController::class, 'deactivate'])->name('employee-allowances.deactivate');
        Route::post('employee-allowances/bulk-update-status', [EmployeeAllowanceController::class, 'bulkUpdateStatus'])->name('employee-allowances.bulk-update-status');
        Route::post('employee-allowances/calculate-total', [EmployeeAllowanceController::class, 'calculateTotalAllowances'])->name('employee-allowances.calculate-total');
        
        // Employee Salary Routes
        Route::resource('employee-salaries', EmployeeSalaryController::class);
        Route::get('employee-salaries/employee/{employee}', [EmployeeSalaryController::class, 'getByEmployee'])->name('employee-salaries.by-employee');
        Route::get('employee-salaries/period/{startDate}/{endDate}', [EmployeeSalaryController::class, 'getByPeriod'])->name('employee-salaries.by-period');
        Route::get('employee-salaries-paid', [EmployeeSalaryController::class, 'getPaidSalaries'])->name('employee-salaries.paid');
        Route::get('employee-salaries-unpaid', [EmployeeSalaryController::class, 'getUnpaidSalaries'])->name('employee-salaries.unpaid');
        Route::get('employee-salaries-overdue', [EmployeeSalaryController::class, 'getOverdueSalaries'])->name('employee-salaries.overdue');
        Route::get('employees/{employee}/salary-data', [EmployeeSalaryController::class, 'getEmployeeData'])->name('employees.salary-data');
        Route::patch('employee-salaries/{employeeSalary}/mark-paid', [EmployeeSalaryController::class, 'markAsPaid'])->name('employee-salaries.mark-paid');
        Route::patch('employee-salaries/{employeeSalary}/mark-unpaid', [EmployeeSalaryController::class, 'markAsUnpaid'])->name('employee-salaries.mark-unpaid');
        Route::post('employee-salaries/bulk-update-payment-status', [EmployeeSalaryController::class, 'bulkUpdatePaymentStatus'])->name('employee-salaries.bulk-update-payment-status');
        Route::post('employee-salaries/generate-report', [EmployeeSalaryController::class, 'generateReport'])->name('employee-salaries.generate-report');
        Route::get('employee-salaries/statistics', [EmployeeSalaryController::class, 'getStatistics'])->name('employee-salaries.statistics');
        Route::post('employee-salaries/{employeeSalary}/duplicate', [EmployeeSalaryController::class, 'duplicateForNextPeriod'])->name('employee-salaries.duplicate');
        
        // Employee Document Routes
        Route::resource('employee-documents', EmployeeDocumentController::class);
        Route::get('employee-documents/employee/{employee}', [EmployeeDocumentController::class, 'getByEmployee'])->name('employee-documents.by-employee');
        Route::get('employee-documents/type/{type}', [EmployeeDocumentController::class, 'getByDocumentType'])->name('employee-documents.by-type');
        Route::get('employee-documents-active', [EmployeeDocumentController::class, 'getActiveDocuments'])->name('employee-documents.active');
        Route::get('employee-documents-expired', [EmployeeDocumentController::class, 'getExpiredDocuments'])->name('employee-documents.expired');
        Route::get('employee-documents-expiring', [EmployeeDocumentController::class, 'getExpiringSoonDocuments'])->name('employee-documents.expiring');
        Route::get('employees/{employee}/document-data', [EmployeeDocumentController::class, 'getEmployeeData'])->name('employees.document-data');
        Route::get('employee-documents/{employeeDocument}/download', [EmployeeDocumentController::class, 'downloadFile'])->name('employee-documents.download');
        Route::patch('employee-documents/{employeeDocument}/update-status', [EmployeeDocumentController::class, 'updateStatus'])->name('employee-documents.update-status');
        Route::post('employee-documents/bulk-update-status', [EmployeeDocumentController::class, 'bulkUpdateStatus'])->name('employee-documents.bulk-update-status');
        Route::post('employee-documents/generate-report', [EmployeeDocumentController::class, 'generateReport'])->name('employee-documents.generate-report');
        Route::get('employee-documents/statistics', [EmployeeDocumentController::class, 'getStatistics'])->name('employee-documents.statistics');
        Route::patch('employee-documents/{employeeDocument}/archive', [EmployeeDocumentController::class, 'archive'])->name('employee-documents.archive');
        Route::patch('employee-documents/{employeeDocument}/restore', [EmployeeDocumentController::class, 'restore'])->name('employee-documents.restore');
        Route::post('employee-documents/{employeeDocument}/renew', [EmployeeDocumentController::class, 'renew'])->name('employee-documents.renew');
        Route::post('employee-documents/{employeeDocument}/duplicate', [EmployeeDocumentController::class, 'duplicate'])->name('employee-documents.duplicate');
        Route::get('employee-documents/expiring-notifications', [EmployeeDocumentController::class, 'getExpiringNotifications'])->name('employee-documents.expiring-notifications');
        
        // Employee Attendance Routes
        Route::resource('employee-attendances', EmployeeAttendanceController::class);
        Route::get('employee-attendances/employee/{employee}', [EmployeeAttendanceController::class, 'getByEmployee'])->name('employee-attendances.by-employee');
        Route::get('employee-attendances/date/{date}', [EmployeeAttendanceController::class, 'getByDate'])->name('employee-attendances.by-date');
        Route::get('employee-attendances/date-range', [EmployeeAttendanceController::class, 'getByDateRange'])->name('employee-attendances.by-date-range');
        Route::get('employees/{employee}/attendance-data', [EmployeeAttendanceController::class, 'getEmployeeData'])->name('employees.attendance-data');
        Route::post('employee-attendances/time-in', [EmployeeAttendanceController::class, 'timeIn'])->name('employee-attendances.time-in');
        Route::post('employee-attendances/time-out', [EmployeeAttendanceController::class, 'timeOut'])->name('employee-attendances.time-out');
        Route::patch('employee-attendances/{employeeAttendance}/approve', [EmployeeAttendanceController::class, 'approve'])->name('employee-attendances.approve');
        Route::patch('employee-attendances/{employeeAttendance}/reject', [EmployeeAttendanceController::class, 'reject'])->name('employee-attendances.reject');
        Route::post('employee-attendances/bulk-approve', [EmployeeAttendanceController::class, 'bulkApprove'])->name('employee-attendances.bulk-approve');
        Route::get('employee-attendances/{employeeAttendance}/download-document', [EmployeeAttendanceController::class, 'downloadDocument'])->name('employee-attendances.download-document');
        Route::post('employee-attendances/generate-report', [EmployeeAttendanceController::class, 'generateReport'])->name('employee-attendances.generate-report');
        Route::get('employee-attendances/statistics', [EmployeeAttendanceController::class, 'getStatistics'])->name('employee-attendances.statistics');
        Route::get('employee-attendances/monthly', [EmployeeAttendanceController::class, 'getMonthlyAttendance'])->name('employee-attendances.monthly');
        Route::get('employee-attendances-today', [EmployeeAttendanceController::class, 'getTodayAttendance'])->name('employee-attendances.today');
        Route::get('employee-attendances-pending', [EmployeeAttendanceController::class, 'getPendingVerifications'])->name('employee-attendances.pending');
        
        // Project Management Routes
        Route::resource('projects', ProjectController::class);
        Route::patch('projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::patch('projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
        Route::patch('projects/{project}/start', [ProjectController::class, 'start'])->name('projects.start');
        Route::patch('projects/{project}/complete', [ProjectController::class, 'complete'])->name('projects.complete');
        Route::patch('projects/{project}/update-progress', [ProjectController::class, 'updateProgress'])->name('projects.update-progress');
        Route::get('projects/{project}/report', [ProjectController::class, 'generateReport'])->name('projects.report');
        Route::get('projects/{project}/sikoja', [SikojaController::class, 'generateSikoja'])->name('projects.sikoja');
        
        // Support Request Routes (Formulir Kebutuhan Pengajuan)
        Route::resource('support-requests', SupportRequestController::class);
        Route::patch('support-requests/{supportRequest}/submit', [SupportRequestController::class, 'submit'])->name('support-requests.submit');
        Route::patch('support-requests/{supportRequest}/approve', [SupportRequestController::class, 'approve'])->name('support-requests.approve');
        Route::patch('support-requests/{supportRequest}/reject', [SupportRequestController::class, 'reject'])->name('support-requests.reject');
        Route::get('support-requests/{supportRequest}/export-pdf', [SupportRequestController::class, 'exportPdf'])->name('support-requests.export-pdf');
        Route::get('support-requests/export-excel', [SupportRequestController::class, 'exportExcel'])->name('support-requests.export-excel');
        
        // SIKOJA Routes
        Route::resource('sikojas', SikojaController::class);
        Route::patch('sikojas/{sikoja}/submit', [SikojaController::class, 'submit'])->name('sikojas.submit');
        Route::patch('sikojas/{sikoja}/verify-pmo', [SikojaController::class, 'verifyPmo'])->name('sikojas.verify-pmo');
        Route::patch('sikojas/{sikoja}/verify-finance', [SikojaController::class, 'verifyFinance'])->name('sikojas.verify-finance');
        Route::patch('sikojas/{sikoja}/verify-other', [SikojaController::class, 'verifyOther'])->name('sikojas.verify-other');
        Route::patch('sikojas/{sikoja}/reject', [SikojaController::class, 'reject'])->name('sikojas.reject');
    });

    // HRD routes
    Route::middleware(['role:hrd'])->group(function () {
        Route::get('/hrd/dashboard', function () {
            return view('hrd.dashboard');
        });
    });

    // Kepala Unit routes
    Route::middleware(['role:kepala_unit'])->group(function () {
        Route::get('/kepala-unit/dashboard', function () {
            return view('kepala-unit.dashboard');
        });
    });

    // Keuangan routes
    Route::middleware(['role:keuangan'])->group(function () {
        Route::get('/keuangan/dashboard', function () {
            return view('keuangan.dashboard');
        });
    });

    // Karyawan routes
    Route::middleware(['role:karyawan'])->group(function () {
        Route::get('/karyawan/dashboard', function () {
            return view('karyawan.dashboard');
        });
    });
    
    // Employee Attendance Portal Routes - Accessible by both admin and karyawan
    Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
        Route::get('/attendance-portal', [App\Http\Controllers\EmployeeAttendancePortalController::class, 'index'])
            ->name('attendance-portal.index');
    });

    // Regular user routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        });
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
