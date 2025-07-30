<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeShift;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        
        if ($employees->isEmpty()) {
            $this->command->info('No employees found. Please run employee seeder first.');
            return;
        }

        $shifts = [
            [
                'shift_name' => 'Shift A',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'shift_duration' => 8.0,
            ],
            [
                'shift_name' => 'Shift B',
                'start_time' => '16:00',
                'end_time' => '00:00',
                'shift_duration' => 8.0,
            ],
            [
                'shift_name' => 'Shift C',
                'start_time' => '00:00',
                'end_time' => '08:00',
                'shift_duration' => 8.0,
            ],
        ];

        $attendanceStatuses = ['hadir', 'izin', 'sakit', 'alpha', 'terlambat'];
        $workDayTypes = ['hari_biasa', 'akhir_pekan', 'hari_libur', 'lembur'];
        $workLocations = ['Kantor Pusat', 'Cabang Jakarta', 'Cabang Surabaya', 'Remote'];
        $supervisors = ['Budi Santoso', 'Siti Nurhaliza', 'Ahmad Rahman', 'Dewi Sartika'];

        // Create shifts for the last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Skip weekends for some variety
            if ($date->isWeekend() && rand(0, 2) == 0) {
                continue;
            }

            foreach ($employees->take(10) as $employee) {
                $shift = $shifts[array_rand($shifts)];
                $attendanceStatus = $attendanceStatuses[array_rand($attendanceStatuses)];
                $workDayType = $date->isWeekend() ? 'akhir_pekan' : $workDayTypes[array_rand($workDayTypes)];
                
                // Higher chance of 'hadir' status
                if (rand(0, 10) < 7) {
                    $attendanceStatus = 'hadir';
                }

                EmployeeShift::create([
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->full_name,
                    'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
                    'shift_date' => $date->format('Y-m-d'),
                    'shift_name' => $shift['shift_name'],
                    'start_time' => $shift['start_time'],
                    'end_time' => $shift['end_time'],
                    'shift_duration' => $shift['shift_duration'],
                    'work_location' => $workLocations[array_rand($workLocations)],
                    'attendance_status' => $attendanceStatus,
                    'work_day_type' => $workDayType,
                    'supervisor_name' => $supervisors[array_rand($supervisors)],
                    'shift_notes' => $this->generateShiftNotes($attendanceStatus, $workDayType),
                    'data_updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Employee shifts seeded successfully!');
    }

    private function generateShiftNotes($attendanceStatus, $workDayType)
    {
        $notes = [
            'hadir' => [
                'Shift berjalan normal',
                'Karyawan hadir tepat waktu',
                'Tidak ada kendala selama shift',
                'Produktivitas baik',
                null, // Some shifts don't have notes
            ],
            'izin' => [
                'Izin keperluan keluarga',
                'Izin sakit ringan',
                'Izin urusan pribadi',
                'Sudah mendapat persetujuan atasan',
            ],
            'sakit' => [
                'Sakit demam',
                'Sakit kepala',
                'Tidak fit untuk bekerja',
                'Sudah ada surat dokter',
            ],
            'alpha' => [
                'Tidak hadir tanpa keterangan',
                'Tidak dapat dihubungi',
                'Perlu tindak lanjut HR',
            ],
            'terlambat' => [
                'Terlambat 15 menit',
                'Terlambat karena macet',
                'Terlambat 30 menit',
                'Sudah diberi peringatan',
            ],
        ];

        if ($workDayType === 'lembur') {
            return 'Shift lembur - ' . ($notes[$attendanceStatus][array_rand($notes[$attendanceStatus])] ?? 'Lembur sesuai kebutuhan proyek');
        }

        if ($workDayType === 'hari_libur') {
            return 'Shift hari libur - ' . ($notes[$attendanceStatus][array_rand($notes[$attendanceStatus])] ?? 'Shift khusus hari libur');
        }

        $noteOptions = $notes[$attendanceStatus] ?? ['Catatan shift'];
        return $noteOptions[array_rand($noteOptions)];
    }
}
