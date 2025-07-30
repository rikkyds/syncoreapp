<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmployeeSalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'nip_nik',
        'position',
        'work_unit',
        'employee_status',
        'salary_date',
        'salary_period',
        'basic_salary',
        'fixed_allowances',
        'variable_allowances',
        'deductions',
        'net_salary',
        'payment_method',
        'account_number',
        'payment_status',
        'payment_date',
        'notes',
        'data_updated_at',
    ];

    protected $casts = [
        'salary_date' => 'date',
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'fixed_allowances' => 'decimal:2',
        'variable_allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'data_updated_at' => 'datetime',
    ];

    // Employee status options
    public static function getEmployeeStatusOptions()
    {
        return [
            'tetap' => 'Karyawan Tetap',
            'kontrak' => 'Karyawan Kontrak',
            'magang' => 'Magang/Internship',
            'lepas' => 'Freelance/Lepas',
            'paruh_waktu' => 'Paruh Waktu',
            'freelance' => 'Freelance',
        ];
    }

    // Payment method options
    public static function getPaymentMethodOptions()
    {
        return [
            'transfer_bank' => 'Transfer Bank',
            'tunai' => 'Tunai',
            'e_wallet' => 'E-Wallet',
            'cek' => 'Cek',
            'giro' => 'Giro',
        ];
    }

    // Payment status options
    public static function getPaymentStatusOptions()
    {
        return [
            'sudah_dibayar' => 'Sudah Dibayar',
            'belum_dibayar' => 'Belum Dibayar',
            'gagal_bayar' => 'Gagal Bayar',
            'pending' => 'Pending',
            'dibatalkan' => 'Dibatalkan',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getEmployeeStatusNameAttribute()
    {
        return self::getEmployeeStatusOptions()[$this->employee_status] ?? $this->employee_status;
    }

    public function getPaymentMethodNameAttribute()
    {
        return self::getPaymentMethodOptions()[$this->payment_method] ?? $this->payment_method;
    }

    public function getPaymentStatusNameAttribute()
    {
        return self::getPaymentStatusOptions()[$this->payment_status] ?? $this->payment_status;
    }

    public function getEmployeeStatusBadgeClassAttribute()
    {
        return match($this->employee_status) {
            'tetap' => 'bg-green-100 text-green-800',
            'kontrak' => 'bg-blue-100 text-blue-800',
            'magang' => 'bg-yellow-100 text-yellow-800',
            'lepas' => 'bg-purple-100 text-purple-800',
            'paruh_waktu' => 'bg-orange-100 text-orange-800',
            'freelance' => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            'sudah_dibayar' => 'bg-green-100 text-green-800',
            'belum_dibayar' => 'bg-red-100 text-red-800',
            'gagal_bayar' => 'bg-red-100 text-red-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'dibatalkan' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedBasicSalaryAttribute()
    {
        return 'Rp ' . number_format($this->basic_salary, 0, ',', '.');
    }

    public function getFormattedFixedAllowancesAttribute()
    {
        return 'Rp ' . number_format($this->fixed_allowances, 0, ',', '.');
    }

    public function getFormattedVariableAllowancesAttribute()
    {
        return 'Rp ' . number_format($this->variable_allowances, 0, ',', '.');
    }

    public function getFormattedDeductionsAttribute()
    {
        return 'Rp ' . number_format($this->deductions, 0, ',', '.');
    }

    public function getFormattedNetSalaryAttribute()
    {
        return 'Rp ' . number_format($this->net_salary, 0, ',', '.');
    }

    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary + $this->fixed_allowances + $this->variable_allowances;
    }

    public function getFormattedGrossSalaryAttribute()
    {
        return 'Rp ' . number_format($this->gross_salary, 0, ',', '.');
    }

    public function getIsPaidAttribute()
    {
        return $this->payment_status === 'sudah_dibayar';
    }

    public function getIsOverdueAttribute()
    {
        if ($this->payment_status === 'sudah_dibayar') {
            return false;
        }

        // Consider overdue if salary date is more than 30 days ago
        return $this->salary_date->lt(Carbon::now()->subDays(30));
    }

    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) {
            return 0;
        }

        return $this->salary_date->diffInDays(Carbon::now()) - 30;
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    public function setSalaryPeriodAttribute($value)
    {
        if ($this->salary_date) {
            $this->attributes['salary_period'] = Carbon::parse($this->salary_date)->locale('id')->isoFormat('MMMM YYYY');
        } else {
            $this->attributes['salary_period'] = $value;
        }
    }

    // Auto-calculate net salary
    public function calculateNetSalary()
    {
        $gross = $this->basic_salary + $this->fixed_allowances + $this->variable_allowances;
        $this->net_salary = $gross - $this->deductions;
        return $this->net_salary;
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'sudah_dibayar');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'belum_dibayar');
    }

    public function scopeOverdue($query)
    {
        return $query->where('payment_status', '!=', 'sudah_dibayar')
                    ->where('salary_date', '<', Carbon::now()->subDays(30));
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByWorkUnit($query, $workUnit)
    {
        return $query->where('work_unit', $workUnit);
    }

    public function scopeByEmployeeStatus($query, $status)
    {
        return $query->where('employee_status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeByPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('salary_date', [$startDate, $endDate]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('salary_date', Carbon::now()->month)
                    ->whereYear('salary_date', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('salary_date', Carbon::now()->year);
    }

    public function scopeLastMonth($query)
    {
        $lastMonth = Carbon::now()->subMonth();
        return $query->whereMonth('salary_date', $lastMonth->month)
                    ->whereYear('salary_date', $lastMonth->year);
    }

    // Static methods for reporting
    public static function getTotalSalaryByPeriod($startDate, $endDate, $workUnit = null)
    {
        $query = self::byPeriod($startDate, $endDate);
        
        if ($workUnit) {
            $query->byWorkUnit($workUnit);
        }

        return $query->sum('net_salary');
    }

    public static function getAverageSalaryByWorkUnit($workUnit, $year = null)
    {
        $query = self::byWorkUnit($workUnit);
        
        if ($year) {
            $query->whereYear('salary_date', $year);
        }

        return $query->avg('net_salary');
    }

    public static function getSalaryStatistics($period = null)
    {
        $query = self::query();
        
        if ($period) {
            $query->whereMonth('salary_date', Carbon::parse($period)->month)
                  ->whereYear('salary_date', Carbon::parse($period)->year);
        }

        return [
            'total_employees' => $query->distinct('employee_id')->count(),
            'total_gross_salary' => $query->sum(\DB::raw('basic_salary + fixed_allowances + variable_allowances')),
            'total_deductions' => $query->sum('deductions'),
            'total_net_salary' => $query->sum('net_salary'),
            'paid_count' => $query->clone()->paid()->count(),
            'unpaid_count' => $query->clone()->unpaid()->count(),
            'overdue_count' => $query->clone()->overdue()->count(),
        ];
    }

    // Boot method for auto-calculations
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($salary) {
            // Auto-calculate net salary
            $salary->calculateNetSalary();
            
            // Auto-set salary period
            if ($salary->salary_date && !$salary->salary_period) {
                $salary->salary_period = Carbon::parse($salary->salary_date)->locale('id')->isoFormat('MMMM YYYY');
            }
            
            // Auto-set data updated timestamp
            $salary->data_updated_at = now();
        });
    }
}
