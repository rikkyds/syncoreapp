<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'request_type',
        'request_number',
        'request_date',
        'requester_employee_id',
        'status',
        'total_request',
        'program_budget',
        'contribution',
        'remaining_budget',
        'tax_included',
        'budget_notes',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'finance_verifier_id',
        'finance_verified_at',
        'finance_notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'request_date' => 'date',
        'approved_at' => 'datetime',
        'finance_verified_at' => 'datetime',
        'tax_included' => 'boolean',
        'total_request' => 'decimal:2',
        'program_budget' => 'decimal:2',
        'contribution' => 'decimal:2',
        'remaining_budget' => 'decimal:2',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function requesterEmployee()
    {
        return $this->belongsTo(Employee::class, 'requester_employee_id');
    }

    public function approvedByEmployee()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function financeVerifier()
    {
        return $this->belongsTo(Employee::class, 'finance_verifier_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function pptDetails()
    {
        return $this->hasMany(PptDetail::class);
    }

    public function pdkDetails()
    {
        return $this->hasMany(PdkDetail::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('request_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByRequester($query, $employeeId)
    {
        return $query->where('requester_employee_id', $employeeId);
    }

    // Accessors
    public function getFormattedTotalRequestAttribute()
    {
        return number_format($this->total_request, 0, ',', '.');
    }

    public function getFormattedProgramBudgetAttribute()
    {
        return number_format($this->program_budget, 0, ',', '.');
    }

    public function getFormattedContributionAttribute()
    {
        return number_format($this->contribution, 0, ',', '.');
    }

    public function getFormattedRemainingBudgetAttribute()
    {
        return number_format($this->remaining_budget, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'submitted' => 'Disubmit',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getTypeLabelAttribute()
    {
        $labels = [
            'ppt' => 'PPT - Pengajuan Penugasan Tim',
            'pdk' => 'PDK - Pengajuan Dukungan Keuangan',
            'pdh' => 'PDH - Pengajuan Dukungan HRD',
            'pds' => 'PDS - Pengajuan Dukungan Sarpras',
            'pdd' => 'PDD - Pengajuan Dukungan Digitalisasi',
        ];

        return $labels[$this->request_type] ?? $this->request_type;
    }

    // Methods
    public function canBeEdited()
    {
        return $this->status === 'draft';
    }

    public function canBeSubmitted()
    {
        return $this->status === 'draft';
    }

    public function canBeApproved()
    {
        return $this->status === 'submitted';
    }

    public function canBeRejected()
    {
        return $this->status === 'submitted';
    }

    public function calculateRemainingBudget()
    {
        if ($this->program_budget > 0) {
            return $this->program_budget - $this->total_request;
        }
        return null;
    }

    public function updateRemainingBudget()
    {
        $this->remaining_budget = $this->calculateRemainingBudget();
        $this->save();
    }
}
