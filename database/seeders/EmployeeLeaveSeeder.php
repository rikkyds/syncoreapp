<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeLeave;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees for sample data
        $employees = Employee::limit(5)->get();

        if ($employees->count() > 0) {
            $leaveTypes = ['annual', 'sick', 'maternity', 'special', 'emergency'];
            $statuses = ['pending', 'approved', 'rejected'];

            foreach ($employees as $index => $employee) {
                // Create 2-3 leave records per employee
                for ($i = 0; $i < rand(2, 3); $i++) {
                    $applicationDate = Carbon::now()->subDays(rand(1, 30));
                    $startDate = $applicationDate->copy()->addDays(rand(1, 7));
                    $endDate = $startDate->copy()->addDays(rand(1, 10));
                    $returnDate = $endDate->copy()->addDay();

                    EmployeeLeave::create([
                        'employee_id' => $employee->id,
                        'full_name' => $employee->full_name,
                        'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
                        'leave_type' => $leaveTypes[array_rand($leaveTypes)],
                        'application_date' => $applicationDate,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'duration_days' => $startDate->diffInDays($endDate) + 1,
                        'status' => $statuses[array_rand($statuses)],
                        'supervisor_name' => 'Manager ' . $employee->workUnit->name ?? 'Manager Unit',
                        'remaining_leave_balance' => rand(5, 12),
                        'leave_reason' => $this->getRandomLeaveReason(),
                        'return_to_work_date' => $returnDate,
                        'data_updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function getRandomLeaveReason(): string
    {
        $reasons = [
            'Keperluan keluarga',
            'Liburan tahunan',
            'Kondisi kesehatan',
            'Acara keluarga',
            'Istirahat',
            'Keperluan pribadi',
            'Menghadiri pernikahan keluarga',
            'Perawatan kesehatan',
            'Liburan bersama keluarga',
            'Keperluan mendesak'
        ];

        return $reasons[array_rand($reasons)];
    }
}
