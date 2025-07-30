<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sikoja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'sikoja_number',
        'sikoja_date',
        'unit_code',
        'situation_description',
        'output_description',
        'start_date',
        'end_date',
        'location',
        'budget_amount',
        'budget_currency',
        'budget_include_tax',
        'budget_notes',
        'cooperation_type',
        'cooperation_other',
        'cooperation_number',
        'cooperation_date',
        'verified_by_pmo',
        'pmo_verifier_id',
        'pmo_verified_at',
        'pmo_notes',
        'verified_by_finance',
        'finance_verifier_id',
        'finance_verified_at',
        'finance_notes',
        'verified_by_other',
        'other_verifier_type',
        'other_verifier_id',
        'other_verified_at',
        'other_notes',
        'status',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sikoja_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'cooperation_date' => 'date',
        'budget_amount' => 'decimal:2',
        'budget_include_tax' => 'boolean',
        'verified_by_pmo' => 'boolean',
        'verified_by_finance' => 'boolean',
        'verified_by_other' => 'boolean',
        'pmo_verified_at' => 'datetime',
        'finance_verified_at' => 'datetime',
        'other_verified_at' => 'datetime',
    ];

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke Employee (Creator)
    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    // Relasi ke Employee (Updater)
    public function updater()
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    // Relasi ke Employee (PMO Verifier)
    public function pmoVerifier()
    {
        return $this->belongsTo(Employee::class, 'pmo_verifier_id');
    }

    // Relasi ke Employee (Finance Verifier)
    public function financeVerifier()
    {
        return $this->belongsTo(Employee::class, 'finance_verifier_id');
    }

    // Relasi ke Employee (Other Verifier)
    public function otherVerifier()
    {
        return $this->belongsTo(Employee::class, 'other_verifier_id');
    }

    // Auto generate SIKOJA number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sikoja) {
            if (empty($sikoja->sikoja_number)) {
                $sikoja->sikoja_number = self::generateSikojaNumber();
            }
            
            if (empty($sikoja->sikoja_date)) {
                $sikoja->sikoja_date = now()->toDateString();
            }
        });
    }

    // Generate SIKOJA number
    public static function generateSikojaNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: SIKOJA/YYYY/MM/XXXX
        $prefix = "SIKOJA/{$year}/{$month}/";
        
        // Get last number for this month
        $lastSikoja = self::where('sikoja_number', 'like', $prefix . '%')
            ->orderBy('sikoja_number', 'desc')
            ->first();
        
        if ($lastSikoja) {
            $lastNumber = (int) substr($lastSikoja->sikoja_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Status options
    public static function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'pending_verification' => 'Menunggu Verifikasi',
            'partially_verified' => 'Sebagian Terverifikasi',
            'fully_verified' => 'Terverifikasi Penuh',
            'rejected' => 'Ditolak',
        ];
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? $this->status;
    }

    // Cooperation type options
    public static function getCooperationTypeOptions()
    {
        return [
            'mou' => 'MOU (Memorandum of Understanding)',
            'spk' => 'SPK (Surat Perintah Kerja)',
            'cl_loa' => 'CL/LoA (Contract Letter/Letter of Agreement)',
            'other' => 'Lainnya',
        ];
    }

    // Get cooperation type label
    public function getCooperationTypeLabelAttribute()
    {
        if ($this->cooperation_type === 'other') {
            return $this->cooperation_other ?? 'Lainnya';
        }
        
        $types = self::getCooperationTypeOptions();
        return $types[$this->cooperation_type] ?? '-';
    }

    // Get formatted budget
    public function getFormattedBudgetAttribute()
    {
        if (!$this->budget_amount) {
            return 'Belum ditentukan';
        }
        
        $formatted = $this->budget_currency . ' ' . number_format($this->budget_amount, 0, ',', '.');
        
        if (!$this->budget_include_tax) {
            $formatted .= ' (belum termasuk pajak)';
        }
        
        return $formatted;
    }

    // Check verification status
    public function getVerificationStatusAttribute()
    {
        $verified = [];
        
        if ($this->verified_by_pmo) {
            $verified[] = 'PMO';
        }
        
        if ($this->verified_by_finance) {
            $verified[] = 'Keuangan';
        }
        
        if ($this->verified_by_other) {
            $verified[] = $this->other_verifier_type ?? 'Lainnya';
        }
        
        return $verified;
    }

    // Get verification percentage
    public function getVerificationPercentageAttribute()
    {
        $total = 0;
        $verified = 0;
        
        // PMO verification (always required)
        $total++;
        if ($this->verified_by_pmo) $verified++;
        
        // Finance verification (always required)
        $total++;
        if ($this->verified_by_finance) $verified++;
        
        // Other verification (optional)
        if ($this->other_verifier_type) {
            $total++;
            if ($this->verified_by_other) $verified++;
        }
        
        return $total > 0 ? round(($verified / $total) * 100) : 0;
    }

    // Update status based on verification
    public function updateStatusBasedOnVerification()
    {
        $requiredVerifications = ['pmo', 'finance'];
        $completedVerifications = [];
        
        if ($this->verified_by_pmo) {
            $completedVerifications[] = 'pmo';
        }
        
        if ($this->verified_by_finance) {
            $completedVerifications[] = 'finance';
        }
        
        // Check if other verification is required
        if ($this->other_verifier_type && $this->verified_by_other) {
            $completedVerifications[] = 'other';
        }
        
        if (count($completedVerifications) === 0) {
            $this->status = 'pending_verification';
        } elseif (count($completedVerifications) < count($requiredVerifications)) {
            $this->status = 'partially_verified';
        } else {
            // Check if other verification is required but not completed
            if ($this->other_verifier_type && !$this->verified_by_other) {
                $this->status = 'partially_verified';
            } else {
                $this->status = 'fully_verified';
            }
        }
        
        $this->save();
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan project
    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sikoja_date', [$startDate, $endDate]);
    }

    // Check if can be edited
    public function canBeEdited()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    // Check if can be verified
    public function canBeVerified()
    {
        return in_array($this->status, ['pending_verification', 'partially_verified']);
    }
}
