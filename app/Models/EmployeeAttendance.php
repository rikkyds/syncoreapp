<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmployeeAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'nip_nik',
        'attendance_date',
        'time_in',
        'time_out',
        'work_duration_minutes',
        'attendance_status',
        'day_type',
        'work_location',
        'notes',
        'supporting_document',
        'attendance_method',
        'supervisor_verification',
        'employee_shift_id',
        'hrd_notes',
        'attendance_input_date',
        'data_updated_at',
        'time_logs',
        'latitude',
        'longitude',
        'device_info',
        'ip_address',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'time_in' => 'datetime:H:i:s',
        'time_out' => 'datetime:H:i:s',
        'attendance_input_date' => 'datetime',
        'data_updated_at' => 'datetime',
        'time_logs' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Attendance status options
    public static function getAttendanceStatusOptions()
    {
        return [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'cuti' => 'Cuti',
            'alpha' => 'Alpha/Tanpa Keterangan',
            'lembur' => 'Lembur',
            'dinas_luar' => 'Dinas Luar',
            'wfh' => 'Work From Home',
            'setengah_hari' => 'Setengah Hari',
            'pulang_cepat' => 'Pulang Cepat',
        ];
    }

    // Day type options
    public static function getDayTypeOptions()
    {
        return [
            'hari_kerja' => 'Hari Kerja',
            'akhir_pekan' => 'Akhir Pekan',
            'hari_libur_nasional' => 'Hari Libur Nasional',
            'hari_libur_khusus' => 'Hari Libur Khusus',
            'hari_cuti_bersama' => 'Hari Cuti Bersama',
        ];
    }

    // Work location options
    public static function getWorkLocationOptions()
    {
        return [
            'kantor_pusat' => 'Kantor Pusat',
            'kantor_cabang' => 'Kantor Cabang',
            'wfh' => 'Work From Home',
            'proyek' => 'Proyek',
            'dinas_luar' => 'Dinas Luar',
            'client_site' => 'Client Site',
            'lapangan' => 'Lapangan',
            'lainnya' => 'Lainnya',
        ];
    }

    // Attendance method options
    public static function getAttendanceMethodOptions()
    {
        return [
            'gps' => 'GPS',
            'selfie' => 'Selfie',
            'fingerprint' => 'Fingerprint',
            'rfid' => 'RFID',
            'aplikasi' => 'Aplikasi',
            'manual' => 'Manual',
            'qr_code' => 'QR Code',
            'face_recognition' => 'Face Recognition',
        ];
    }

    // Supervisor verification options
    public static function getSupervisorVerificationOptions()
    {
        return [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'not_required' => 'Tidak Diperlukan',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employeeShift()
    {
        return $this->belongsTo(EmployeeShift::class);
    }

    // Accessors
    public function getAttendanceStatusNameAttribute()
    {
        return self::getAttendanceStatusOptions()[$this->attendance_status] ?? $this->attendance_status;
    }

    public function getDayTypeNameAttribute()
    {
        return self::getDayTypeOptions()[$this->day_type] ?? $this->day_type;
    }

    public function getWorkLocationNameAttribute()
    {
        return self::getWorkLocationOptions()[$this->work_location] ?? $this->work_location;
    }

    public function getAttendanceMethodNameAttribute()
    {
        return self::getAttendanceMethodOptions()[$this->attendance_method] ?? $this->attendance_method;
    }

    public function getSupervisorVerificationNameAttribute()
    {
        return self::getSupervisorVerificationOptions()[$this->supervisor_verification] ?? $this->supervisor_verification;
    }

    public function getAttendanceStatusBadgeClassAttribute()
    {
        return match($this->attendance_status) {
            'hadir' => 'bg-green-100 text-green-800',
            'terlambat' => 'bg-yellow-100 text-yellow-800',
            'izin' => 'bg-blue-100 text-blue-800',
            'sakit' => 'bg-orange-100 text-orange-800',
            'cuti' => 'bg-purple-100 text-purple-800',
            'alpha' => 'bg-red-100 text-red-800',
            'lembur' => 'bg-indigo-100 text-indigo-800',
            'dinas_luar' => 'bg-cyan-100 text-cyan-800',
            'wfh' => 'bg-teal-100 text-teal-800',
            'setengah_hari' => 'bg-amber-100 text-amber-800',
            'pulang_cepat' => 'bg-lime-100 text-lime-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getSupervisorVerificationBadgeClassAttribute()
    {
        return match($this->supervisor_verification) {
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'not_required' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getWorkLocationBadgeClassAttribute()
    {
        return match($this->work_location) {
            'kantor_pusat' => 'bg-blue-100 text-blue-800',
            'kantor_cabang' => 'bg-indigo-100 text-indigo-800',
            'wfh' => 'bg-green-100 text-green-800',
            'proyek' => 'bg-purple-100 text-purple-800',
            'dinas_luar' => 'bg-orange-100 text-orange-800',
            'client_site' => 'bg-cyan-100 text-cyan-800',
            'lapangan' => 'bg-yellow-100 text-yellow-800',
            'lainnya' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedWorkDurationAttribute()
    {
        if (!$this->work_duration_minutes) {
            return '-';
        }

        $hours = floor($this->work_duration_minutes / 60);
        $minutes = $this->work_duration_minutes % 60;

        return sprintf('%d jam %d menit', $hours, $minutes);
    }

    public function getIsLateAttribute()
    {
        return $this->attendance_status === 'terlambat';
    }

    public function getIsAbsentAttribute()
    {
        return in_array($this->attendance_status, ['alpha', 'izin', 'sakit', 'cuti']);
    }

    public function getIsPresentAttribute()
    {
        return in_array($this->attendance_status, ['hadir', 'terlambat', 'lembur', 'wfh', 'dinas_luar']);
    }

    public function getHasSupportingDocumentAttribute()
    {
        return !empty($this->supporting_document);
    }

    public function getTimeLogsCountAttribute()
    {
        return $this->time_logs ? count($this->time_logs) : 0;
    }

    public function getFirstTimeInAttribute()
    {
        if ($this->time_logs && count($this->time_logs) > 0) {
            return $this->time_logs[0]['time_in'] ?? null;
        }
        return $this->time_in;
    }

    public function getLastTimeOutAttribute()
    {
        if ($this->time_logs && count($this->time_logs) > 0) {
            $lastLog = end($this->time_logs);
            return $lastLog['time_out'] ?? null;
        }
        return $this->time_out;
    }

    public function getTotalWorkDurationAttribute()
    {
        if ($this->time_logs && count($this->time_logs) > 0) {
            $totalMinutes = 0;
            foreach ($this->time_logs as $log) {
                if (isset($log['time_in']) && isset($log['time_out'])) {
                    $timeIn = Carbon::parse($log['time_in']);
                    $timeOut = Carbon::parse($log['time_out']);
                    $totalMinutes += $timeOut->diffInMinutes($timeIn);
                }
            }
            return $totalMinutes;
        }

        return $this->work_duration_minutes ?? 0;
    }

    public function getFormattedTotalWorkDurationAttribute()
    {
        $totalMinutes = $this->total_work_duration;
        if (!$totalMinutes) {
            return '-';
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%d jam %d menit', $hours, $minutes);
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    public function setAttendanceInputDateAttribute($value)
    {
        $this->attributes['attendance_input_date'] = $value ?? now();
    }

    // Time logs management methods
    public function addTimeLog($timeIn, $timeOut = null, $notes = null)
    {
        $timeLogs = $this->time_logs ?? [];
        
        $newLog = [
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'notes' => $notes,
            'created_at' => now()->toISOString(),
        ];

        $timeLogs[] = $newLog;
        $this->time_logs = $timeLogs;
        
        // Update main time_in and time_out
        $this->updateMainTimeFields();
        
        return $this;
    }

    public function updateTimeLog($index, $timeIn = null, $timeOut = null, $notes = null)
    {
        $timeLogs = $this->time_logs ?? [];
        
        if (isset($timeLogs[$index])) {
            if ($timeIn !== null) $timeLogs[$index]['time_in'] = $timeIn;
            if ($timeOut !== null) $timeLogs[$index]['time_out'] = $timeOut;
            if ($notes !== null) $timeLogs[$index]['notes'] = $notes;
            $timeLogs[$index]['updated_at'] = now()->toISOString();
            
            $this->time_logs = $timeLogs;
            $this->updateMainTimeFields();
        }
        
        return $this;
    }

    public function removeTimeLog($index)
    {
        $timeLogs = $this->time_logs ?? [];
        
        if (isset($timeLogs[$index])) {
            unset($timeLogs[$index]);
            $this->time_logs = array_values($timeLogs); // Re-index array
            $this->updateMainTimeFields();
        }
        
        return $this;
    }

    private function updateMainTimeFields()
    {
        if ($this->time_logs && count($this->time_logs) > 0) {
            // Set first time_in
            $this->time_in = $this->first_time_in;
            
            // Set last time_out
            $this->time_out = $this->last_time_out;
            
            // Calculate total work duration
            $this->work_duration_minutes = $this->total_work_duration;
        }
    }

    // Calculate work duration automatically
    public function calculateWorkDuration()
    {
        if ($this->time_logs && count($this->time_logs) > 0) {
            $this->work_duration_minutes = $this->total_work_duration;
        } elseif ($this->time_in && $this->time_out) {
            $timeIn = Carbon::parse($this->time_in);
            $timeOut = Carbon::parse($this->time_out);
            $this->work_duration_minutes = $timeOut->diffInMinutes($timeIn);
        }
        
        return $this;
    }

    // Scopes
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('attendance_date', $date);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('attendance_status', $status);
    }

    public function scopeByWorkLocation($query, $location)
    {
        return $query->where('work_location', $location);
    }

    public function scopePresent($query)
    {
        return $query->whereIn('attendance_status', ['hadir', 'terlambat', 'lembur', 'wfh', 'dinas_luar']);
    }

    public function scopeAbsent($query)
    {
        return $query->whereIn('attendance_status', ['alpha', 'izin', 'sakit', 'cuti']);
    }

    public function scopeLate($query)
    {
        return $query->where('attendance_status', 'terlambat');
    }

    public function scopePendingVerification($query)
    {
        return $query->where('supervisor_verification', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('supervisor_verification', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('supervisor_verification', 'rejected');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('attendance_date', Carbon::now()->month)
                    ->whereYear('attendance_date', Carbon::now()->year);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('attendance_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeToday($query)
    {
        return $query->where('attendance_date', Carbon::today());
    }

    // Static methods for reporting
    public static function getAttendanceStatistics($employeeId = null, $startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($employeeId) {
            $query->byEmployee($employeeId);
        }
        
        if ($startDate && $endDate) {
            $query->byDateRange($startDate, $endDate);
        }

        return [
            'total_days' => $query->count(),
            'present_days' => $query->clone()->present()->count(),
            'absent_days' => $query->clone()->absent()->count(),
            'late_days' => $query->clone()->late()->count(),
            'pending_verification' => $query->clone()->pendingVerification()->count(),
            'total_work_hours' => round($query->sum('work_duration_minutes') / 60, 2),
            'average_work_hours' => round($query->avg('work_duration_minutes') / 60, 2),
        ];
    }

    public static function getMonthlyAttendance($employeeId, $year, $month)
    {
        return self::byEmployee($employeeId)
                  ->whereYear('attendance_date', $year)
                  ->whereMonth('attendance_date', $month)
                  ->orderBy('attendance_date')
                  ->get();
    }

    // Boot method for auto-calculations
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            // Auto-calculate work duration
            $attendance->calculateWorkDuration();
            
            // Auto-set attendance input date if not set
            if (!$attendance->attendance_input_date) {
                $attendance->attendance_input_date = now();
            }
            
            // Auto-set data updated timestamp
            $attendance->data_updated_at = now();
            
            // Auto-determine if late based on shift (if shift is linked)
            if ($attendance->employeeShift && $attendance->time_in) {
                $shiftStartTime = Carbon::parse($attendance->employeeShift->start_time);
                $actualTimeIn = Carbon::parse($attendance->time_in);
                
                if ($actualTimeIn->gt($shiftStartTime->addMinutes(15))) { // 15 minutes tolerance
                    $attendance->attendance_status = 'terlambat';
                }
            }
        });
    }
}
