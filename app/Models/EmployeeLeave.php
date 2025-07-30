<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'full_name',
        'nip_nik',
        'leave_type',
        'application_date',
        'start_date',
        'end_date',
        'duration_days',
        'status',
        'supervisor_name',
        'remaining_leave_balance',
        'leave_reason',
        'return_to_work_date',
        'supporting_document',
        'data_updated_at',
    ];

    protected $casts = [
        'application_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'return_to_work_date' => 'date',
        'data_updated_at' => 'datetime',
    ];

    // Leave type options
    public static function getLeaveTypes()
    {
        return [
            'annual' => 'Cuti Tahunan',
            'sick' => 'Cuti Sakit',
            'maternity' => 'Cuti Melahirkan',
            'paternity' => 'Cuti Ayah',
            'special' => 'Cuti Khusus',
            'unpaid' => 'Cuti Tanpa Gaji',
            'emergency' => 'Cuti Darurat',
        ];
    }

    // Status options
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getLeaveTypeNameAttribute()
    {
        return self::getLeaveTypes()[$this->leave_type] ?? $this->leave_type;
    }

    public function getStatusNameAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByLeaveType($query, $type)
    {
        return $query->where('leave_type', $type);
    }
}
