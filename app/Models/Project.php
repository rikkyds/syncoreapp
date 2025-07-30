<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'submission_date',
        'submitter_employee_id',
        'submitter_position_id',
        'initiator_employee_id',
        'initiator_position_id',
        'objective',
        'program_name',
        'program_code',
        'activity_name',
        'activity_code',
        'project_name',
        'project_sequence_number',
        'final_project_code',
        'target',
        'specific_target',
        'current_achievement',
        'key_result',
        'need_team_assignment',
        'need_hrd_support',
        'need_facility_support',
        'need_digitalization_support',
        'need_financial_support',
        'additional_notes',
        'proposal_document',
        'proposal_document_original_name',
        'evidence_document',
        'evidence_document_original_name',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'approved_at' => 'datetime',
        'need_team_assignment' => 'boolean',
        'need_hrd_support' => 'boolean',
        'need_facility_support' => 'boolean',
        'need_digitalization_support' => 'boolean',
        'need_financial_support' => 'boolean',
    ];

    // Relasi ke Employee (Pengaju)
    public function submitter()
    {
        return $this->belongsTo(Employee::class, 'submitter_employee_id');
    }

    // Relasi ke Position (Jabatan Pengaju)
    public function submitterPosition()
    {
        return $this->belongsTo(Position::class, 'submitter_position_id');
    }

    // Relasi ke Employee (Inisiator)
    public function initiator()
    {
        return $this->belongsTo(Employee::class, 'initiator_employee_id');
    }

    // Relasi ke Position (Jabatan Inisiator)
    public function initiatorPosition()
    {
        return $this->belongsTo(Position::class, 'initiator_position_id');
    }

    // Relasi ke Employee (Yang Menyetujui)
    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    // Relasi ke SIKOJA
    public function sikoja()
    {
        return $this->hasOne(Sikoja::class);
    }

    // Auto generate final project code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->final_project_code)) {
                $project->final_project_code = $project->activity_code . '-' . str_pad($project->project_sequence_number, 3, '0', STR_PAD_LEFT);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty(['activity_code', 'project_sequence_number'])) {
                $project->final_project_code = $project->activity_code . '-' . str_pad($project->project_sequence_number, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Status options
    public static function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'in_progress' => 'Sedang Berjalan',
            'completed' => 'Selesai',
        ];
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? $this->status;
    }

    // Get progress percentage
    public function getProgressPercentageAttribute()
    {
        if ($this->target == 0) return 0;
        return min(100, round(($this->current_achievement / $this->target) * 100, 2));
    }

    // Get support needs as array
    public function getSupportNeedsAttribute()
    {
        $needs = [];
        if ($this->need_team_assignment) $needs[] = 'Pengajuan Penugasan Tim (PPT)';
        if ($this->need_hrd_support) $needs[] = 'Pengajuan Dukungan HRD (PDH)';
        if ($this->need_facility_support) $needs[] = 'Pengajuan Dukungan Sarpras (PDS)';
        if ($this->need_digitalization_support) $needs[] = 'Pengajuan Dukungan Digitalisasi (PDD)';
        if ($this->need_financial_support) $needs[] = 'Pengajuan Dukungan Keuangan (PDK)';
        
        return $needs;
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan pengaju
    public function scopeBySubmitter($query, $employeeId)
    {
        return $query->where('submitter_employee_id', $employeeId);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('submission_date', [$startDate, $endDate]);
    }

    // Check if project can be edited
    public function canBeEdited()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    // Check if project can be approved
    public function canBeApproved()
    {
        return $this->status === 'pending';
    }

    // Check if project can be started
    public function canBeStarted()
    {
        return $this->status === 'approved';
    }
}
