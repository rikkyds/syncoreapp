<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmployeeAllowance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'nip_nik',
        'work_unit',
        'position',
        'allowance_type',
        'allowance_amount',
        'payment_frequency',
        'allowance_status',
        'start_date',
        'end_date',
        'terms_conditions',
        'payment_method',
        'data_updated_at',
    ];

    protected $casts = [
        'allowance_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'data_updated_at' => 'datetime',
    ];

    // Allowance type options
    public static function getAllowanceTypeOptions()
    {
        return [
            'tunjangan_tetap' => 'Tunjangan Tetap',
            'tunjangan_tidak_tetap' => 'Tunjangan Tidak Tetap',
            'tunjangan_transportasi' => 'Tunjangan Transportasi',
            'tunjangan_makan' => 'Tunjangan Makan',
            'tunjangan_kesehatan' => 'Tunjangan Kesehatan',
            'tunjangan_anak' => 'Tunjangan Anak',
            'tunjangan_jabatan' => 'Tunjangan Jabatan',
            'tunjangan_kinerja' => 'Tunjangan Kinerja',
            'tunjangan_lembur' => 'Tunjangan Lembur',
            'tunjangan_khusus' => 'Tunjangan Khusus',
        ];
    }

    // Payment frequency options
    public static function getPaymentFrequencyOptions()
    {
        return [
            'bulanan' => 'Bulanan',
            'mingguan' => 'Mingguan',
            'sekali' => 'Sekali',
            'tahunan' => 'Tahunan',
            'per_proyek' => 'Per Proyek',
            'harian' => 'Harian',
            'per_kehadiran' => 'Per Kehadiran',
        ];
    }

    // Allowance status options
    public static function getAllowanceStatusOptions()
    {
        return [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'ditangguhkan' => 'Ditangguhkan',
            'sementara' => 'Sementara',
        ];
    }

    // Payment method options
    public static function getPaymentMethodOptions()
    {
        return [
            'bersamaan_gaji' => 'Bersamaan dengan Gaji',
            'terpisah' => 'Dibayarkan Terpisah',
            'reimburse' => 'Reimburse',
            'transfer_langsung' => 'Transfer Langsung',
            'tunai' => 'Tunai',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getAllowanceTypeNameAttribute()
    {
        return self::getAllowanceTypeOptions()[$this->allowance_type] ?? $this->allowance_type;
    }

    public function getPaymentFrequencyNameAttribute()
    {
        return self::getPaymentFrequencyOptions()[$this->payment_frequency] ?? $this->payment_frequency;
    }

    public function getAllowanceStatusNameAttribute()
    {
        return self::getAllowanceStatusOptions()[$this->allowance_status] ?? $this->allowance_status;
    }

    public function getPaymentMethodNameAttribute()
    {
        return self::getPaymentMethodOptions()[$this->payment_method] ?? $this->payment_method;
    }

    public function getAllowanceStatusBadgeClassAttribute()
    {
        return match($this->allowance_status) {
            'aktif' => 'bg-green-100 text-green-800',
            'tidak_aktif' => 'bg-red-100 text-red-800',
            'ditangguhkan' => 'bg-yellow-100 text-yellow-800',
            'sementara' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getAllowanceTypeBadgeClassAttribute()
    {
        return match($this->allowance_type) {
            'tunjangan_tetap' => 'bg-green-100 text-green-800',
            'tunjangan_tidak_tetap' => 'bg-blue-100 text-blue-800',
            'tunjangan_transportasi' => 'bg-purple-100 text-purple-800',
            'tunjangan_makan' => 'bg-orange-100 text-orange-800',
            'tunjangan_kesehatan' => 'bg-red-100 text-red-800',
            'tunjangan_anak' => 'bg-pink-100 text-pink-800',
            'tunjangan_jabatan' => 'bg-indigo-100 text-indigo-800',
            'tunjangan_kinerja' => 'bg-yellow-100 text-yellow-800',
            'tunjangan_lembur' => 'bg-gray-100 text-gray-800',
            'tunjangan_khusus' => 'bg-teal-100 text-teal-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedAllowanceAmountAttribute()
    {
        return 'Rp ' . number_format($this->allowance_amount, 0, ',', '.');
    }

    public function getIsActiveAttribute()
    {
        if ($this->allowance_status !== 'aktif') {
            return false;
        }

        $now = Carbon::now();
        
        if ($now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && Carbon::now()->gt($this->end_date);
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $remaining = Carbon::now()->diffInDays($this->end_date, false);
        return $remaining > 0 ? $remaining : 0;
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('allowance_status', 'aktif')
                    ->where('start_date', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    public function scopeInactive($query)
    {
        return $query->where('allowance_status', 'tidak_aktif');
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('end_date')
                    ->where('end_date', '<', now());
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByAllowanceType($query, $type)
    {
        return $query->where('allowance_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('allowance_status', $status);
    }

    public function scopeByWorkUnit($query, $workUnit)
    {
        return $query->where('work_unit', $workUnit);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByPaymentFrequency($query, $frequency)
    {
        return $query->where('payment_frequency', $frequency);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('start_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
    }

    public function scopeThisYear($query)
    {
        return $query->whereBetween('start_date', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear()
        ]);
    }

    // Calculate total allowance for a period
    public function calculateTotalForPeriod($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Check if allowance is active during the period
        if ($this->start_date->gt($end) || ($this->end_date && $this->end_date->lt($start))) {
            return 0;
        }

        // Adjust period to allowance validity
        $periodStart = $start->max($this->start_date);
        $periodEnd = $this->end_date ? $end->min($this->end_date) : $end;

        return match($this->payment_frequency) {
            'bulanan' => $this->allowance_amount * $periodStart->diffInMonths($periodEnd, false),
            'mingguan' => $this->allowance_amount * $periodStart->diffInWeeks($periodEnd, false),
            'harian' => $this->allowance_amount * $periodStart->diffInDays($periodEnd, false),
            'tahunan' => $this->allowance_amount * $periodStart->diffInYears($periodEnd, false),
            'sekali', 'per_proyek' => $this->allowance_amount,
            'per_kehadiran' => 0, // Needs attendance data
            default => 0,
        };
    }
}
