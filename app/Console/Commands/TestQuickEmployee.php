<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestQuickEmployee extends Command
{
    protected $signature = 'test:quick-employee';
    protected $description = 'Test quick employee creation';

    public function handle()
    {
        $this->info('Testing quick employee creation...');
        
        try {
            // Check if role exists
            $defaultRole = Role::where('name', 'karyawan')->first();
            if (!$defaultRole) {
                $this->error('Role "karyawan" not found!');
                return;
            }
            
            $this->info('Role found: ' . $defaultRole->name);
            
            // Generate employee ID
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $nextId = $lastEmployee ? $lastEmployee->id + 1 : 1;
            $employeeId = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            $this->info('Generated Employee ID: ' . $employeeId);
            
            DB::beginTransaction();
            
            // Test data
            $testData = [
                'full_name' => 'Test Employee',
                'phone_number' => '08123456789',
                'personal_email' => 'test' . time() . '@example.com',
            ];
            
            $this->info('Creating user...');
            
            // Create user
            $user = User::create([
                'name' => $testData['full_name'],
                'email' => $testData['personal_email'],
                'password' => Hash::make('syncore123'),
                'role_id' => $defaultRole->id,
                'email_verified_at' => now(),
            ]);
            
            $this->info('User created with ID: ' . $user->id);
            
            // Get default values for required foreign keys
            $defaultCompany = \App\Models\Company::first();
            $defaultBranchOffice = \App\Models\BranchOffice::first();
            $defaultWorkUnit = \App\Models\WorkUnit::first();
            $defaultPosition = \App\Models\Position::first();
            
            // Create default position if none exists
            if (!$defaultPosition) {
                $defaultPosition = \App\Models\Position::create([
                    'name' => 'Staff',
                    'description' => 'Default Staff Position'
                ]);
            }
            
            $this->info('Using defaults: Company=' . $defaultCompany->id . ', Branch=' . $defaultBranchOffice->id . ', WorkUnit=' . $defaultWorkUnit->id . ', Position=' . $defaultPosition->id);

            // Create employee
            $this->info('Creating employee...');
            
            $employee = Employee::create([
                'full_name' => $testData['full_name'],
                'phone_number' => $testData['phone_number'],
                'personal_email' => $testData['personal_email'],
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
            
            $this->info('Employee created with ID: ' . $employee->id);
            
            DB::commit();
            
            $this->info('SUCCESS! Employee created successfully.');
            $this->info('Email: ' . $testData['personal_email']);
            $this->info('Password: syncore123');
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('ERROR: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile());
            $this->error('Line: ' . $e->getLine());
        }
    }
}
