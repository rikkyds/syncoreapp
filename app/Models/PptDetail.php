<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PptDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_request_id',
        'business_process',
        'function_type',
        'role',
        'assigned_employee_id',
        'task_description',
        'output_description',
        'start_date',
        'end_date',
        'location',
        'status',
        'completion_notes',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function supportRequest()
    {
        return $this->belongsTo(SupportRequest::class);
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('assigned_employee_id', $employeeId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getFormattedDateRangeAttribute()
    {
        return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
    }

    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    // Methods
    public function canBeStarted()
    {
        return $this->status === 'pending' && $this->supportRequest->status === 'approved';
    }

    public function canBeCompleted()
    {
        return $this->status === 'in_progress';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'in_progress']);
    }

    public function markAsInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsCompleted($notes = null)
    {
        $this->update([
            'status' => 'completed',
            'completion_notes' => $notes,
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled($notes = null)
    {
        $this->update([
            'status' => 'cancelled',
            'completion_notes' => $notes,
        ]);
    }
}
