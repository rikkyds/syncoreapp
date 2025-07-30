<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmployeeShift extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'nip_nik',
        'shift_date',
        'shift_name',
        'start_time',
        'end_time',
        'shift_duration',
        'work_location',
        'attendance_status',
        'work_day_type',
        'supervisor_name',
        'shift_notes',
        'data_updated_at',
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'shift_duration' => 'decimal:2',
        'data_updated_at' => 'datetime',
    ];

    // Attendance status options
    public static function getAttendanceStatusOptions()
    {
        return [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            'terlambat' => 'Terlambat',
            'pulang_cepat' => 'Pulang Cepat',
        ];
    }

    // Work day type options
    public static function getWorkDayTypeOptions()
    {
        return [
            'hari_biasa' => 'Hari Biasa',
            'akhir_pekan' => 'Akhir Pekan',
            'hari_libur' => 'Hari Libur Nasional',
            'lembur' => 'Lembur',
            'hari_khusus' => 'Hari Khusus',
        ];
    }

    // Shift name options
    public static function getShiftNameOptions()
    {
        return [
            'Shift A' => 'Shift A (Pagi)',
            'Shift B' => 'Shift B (Siang)',
            'Shift C' => 'Shift C (Malam)',
            'Shift Khusus' => 'Shift Khusus',
            'Shift Lembur' => 'Shift Lembur',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getAttendanceStatusNameAttribute()
    {
        return self::getAttendanceStatusOptions()[$this->attendance_status] ?? $this->attendance_status;
    }

    public function getWorkDayTypeNameAttribute()
    {
        return self::getWorkDayTypeOptions()[$this->work_day_type] ?? $this->work_day_type;
    }

    public function getAttendanceStatusBadgeClassAttribute()
    {
        return match($this->attendance_status) {
            'hadir' => 'bg-green-100 text-green-800',
            'izin' => 'bg-blue-100 text-blue-800',
            'sakit' => 'bg-yellow-100 text-yellow-800',
            'alpha' => 'bg-red-100 text-red-800',
            'terlambat' => 'bg-orange-100 text-orange-800',
            'pulang_cepat' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getWorkDayTypeBadgeClassAttribute()
    {
        return match($this->work_day_type) {
            'hari_biasa' => 'bg-gray-100 text-gray-800',
            'akhir_pekan' => 'bg-blue-100 text-blue-800',
            'hari_libur' => 'bg-red-100 text-red-800',
            'lembur' => 'bg-yellow-100 text-yellow-800',
            'hari_khusus' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : '';
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : '';
    }

    public function getFormattedShiftDurationAttribute()
    {
        return $this->shift_duration . ' jam';
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    // Calculate shift duration automatically
    public function calculateShiftDuration()
    {
        if ($this->start_time && $this->end_time) {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);
            
            // Handle overnight shifts
            if ($end->lt($start)) {
                $end->addDay();
            }
            
            $this->shift_duration = $start->diffInHours($end, true);
        }
    }

    // Scopes
    public function scopeByDate($query, $date)
    {
        return $query->where('shift_date', $date);
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByShift($query, $shiftName)
    {
        return $query->where('shift_name', $shiftName);
    }

    public function scopeByAttendanceStatus($query, $status)
    {
        return $query->where('attendance_status', $status);
    }

    public function scopeByWorkDayType($query, $type)
    {
        return $query->where('work_day_type', $type);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('shift_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('shift_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
    }
}
