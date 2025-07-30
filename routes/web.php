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
        Route::resource('employees.education', EducationController::class)->except(['index', 'show']);
        Route::resource('employees.skills', SkillController::class)->except(['index', 'show']);
        Route::resource('employees.work-experiences', WorkExperienceController::class)->except(['index', 'show']);
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
