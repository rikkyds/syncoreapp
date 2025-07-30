<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmployeeDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'nip_nik',
        'document_type',
        'document_number',
        'issue_date',
        'effective_date',
        'expiry_date',
        'signatory',
        'document_status',
        'storage_location',
        'file_path',
        'additional_notes',
        'data_updated_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'data_updated_at' => 'datetime',
    ];

    // Document type options
    public static function getDocumentTypeOptions()
    {
        return [
            'kontrak_kerja' => 'Kontrak Kerja',
            'sk_pengangkatan' => 'SK Pengangkatan',
            'sk_mutasi' => 'SK Mutasi',
            'sk_promosi' => 'SK Promosi',
            'sk_demosi' => 'SK Demosi',
            'surat_peringatan' => 'Surat Peringatan',
            'surat_teguran' => 'Surat Teguran',
            'perjanjian_kerja' => 'Perjanjian Kerja',
            'addendum_kontrak' => 'Addendum Kontrak',
            'surat_penugasan' => 'Surat Penugasan',
            'surat_izin' => 'Surat Izin',
            'surat_cuti' => 'Surat Cuti',
            'surat_resign' => 'Surat Resign',
            'surat_phk' => 'Surat PHK',
            'sertifikat' => 'Sertifikat',
            'ijazah' => 'Ijazah',
            'transkrip' => 'Transkrip Nilai',
            'cv' => 'Curriculum Vitae',
            'foto' => 'Foto',
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'npwp' => 'NPWP',
            'bpjs' => 'BPJS',
            'dokumen_lainnya' => 'Dokumen Lainnya',
        ];
    }

    // Document status options
    public static function getDocumentStatusOptions()
    {
        return [
            'aktif' => 'Aktif',
            'kadaluarsa' => 'Kadaluarsa',
            'diperbarui' => 'Diperbarui',
            'sedang_diproses' => 'Sedang Diproses',
            'draft' => 'Draft',
            'ditolak' => 'Ditolak',
            'dibatalkan' => 'Dibatalkan',
            'arsip' => 'Arsip',
        ];
    }

    // Storage location options
    public static function getStorageLocationOptions()
    {
        return [
            'hardcopy' => 'Hardcopy/Fisik',
            'drive_internal' => 'Drive Internal',
            'cloud_storage' => 'Cloud Storage',
            'aplikasi_tertentu' => 'Aplikasi Tertentu',
            'server_lokal' => 'Server Lokal',
            'email' => 'Email',
            'kombinasi' => 'Kombinasi',
        ];
    }

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getDocumentTypeNameAttribute()
    {
        return self::getDocumentTypeOptions()[$this->document_type] ?? $this->document_type;
    }

    public function getDocumentStatusNameAttribute()
    {
        return self::getDocumentStatusOptions()[$this->document_status] ?? $this->document_status;
    }

    public function getStorageLocationNameAttribute()
    {
        return self::getStorageLocationOptions()[$this->storage_location] ?? $this->storage_location;
    }

    public function getDocumentTypeBadgeClassAttribute()
    {
        return match($this->document_type) {
            'kontrak_kerja', 'perjanjian_kerja' => 'bg-blue-100 text-blue-800',
            'sk_pengangkatan', 'sk_promosi' => 'bg-green-100 text-green-800',
            'sk_mutasi', 'sk_demosi' => 'bg-yellow-100 text-yellow-800',
            'surat_peringatan', 'surat_teguran' => 'bg-red-100 text-red-800',
            'surat_resign', 'surat_phk' => 'bg-gray-100 text-gray-800',
            'sertifikat', 'ijazah' => 'bg-purple-100 text-purple-800',
            'ktp', 'kk', 'npwp', 'bpjs' => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getDocumentStatusBadgeClassAttribute()
    {
        return match($this->document_status) {
            'aktif' => 'bg-green-100 text-green-800',
            'kadaluarsa' => 'bg-red-100 text-red-800',
            'diperbarui' => 'bg-blue-100 text-blue-800',
            'sedang_diproses' => 'bg-yellow-100 text-yellow-800',
            'draft' => 'bg-gray-100 text-gray-800',
            'ditolak' => 'bg-red-100 text-red-800',
            'dibatalkan' => 'bg-gray-100 text-gray-800',
            'arsip' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStorageLocationBadgeClassAttribute()
    {
        return match($this->storage_location) {
            'hardcopy' => 'bg-brown-100 text-brown-800',
            'drive_internal' => 'bg-blue-100 text-blue-800',
            'cloud_storage' => 'bg-sky-100 text-sky-800',
            'aplikasi_tertentu' => 'bg-purple-100 text-purple-800',
            'server_lokal' => 'bg-green-100 text-green-800',
            'email' => 'bg-orange-100 text-orange-800',
            'kombinasi' => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && Carbon::now()->gt($this->expiry_date);
    }

    public function getIsExpiringSoonAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }

        return Carbon::now()->diffInDays($this->expiry_date, false) <= 30 && 
               Carbon::now()->diffInDays($this->expiry_date, false) > 0;
    }

    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->expiry_date) {
            return null;
        }

        $days = Carbon::now()->diffInDays($this->expiry_date, false);
        return $days > 0 ? $days : 0;
    }

    public function getIsActiveAttribute()
    {
        if ($this->document_status !== 'aktif') {
            return false;
        }

        $now = Carbon::now();
        
        if ($now->lt($this->effective_date)) {
            return false;
        }

        if ($this->expiry_date && $now->gt($this->expiry_date)) {
            return false;
        }

        return true;
    }

    public function getHasFileAttribute()
    {
        return !empty($this->file_path);
    }

    public function getFileExtensionAttribute()
    {
        if (!$this->has_file) {
            return null;
        }

        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    public function getFileSizeAttribute()
    {
        if (!$this->has_file || !file_exists(storage_path('app/public/' . $this->file_path))) {
            return null;
        }

        $bytes = filesize(storage_path('app/public/' . $this->file_path));
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Mutators
    public function setDataUpdatedAtAttribute($value)
    {
        $this->attributes['data_updated_at'] = now();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('document_status', 'aktif')
                    ->where('effective_date', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('expiry_date')
                          ->orWhere('expiry_date', '>=', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
                    ->where('expiry_date', '<', now());
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('expiry_date')
                    ->whereBetween('expiry_date', [
                        now(),
                        now()->addDays($days)
                    ]);
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByDocumentType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('document_status', $status);
    }

    public function scopeByStorageLocation($query, $location)
    {
        return $query->where('storage_location', $location);
    }

    public function scopeWithFiles($query)
    {
        return $query->whereNotNull('file_path');
    }

    public function scopeWithoutFiles($query)
    {
        return $query->whereNull('file_path');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('issue_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
    }

    public function scopeThisYear($query)
    {
        return $query->whereBetween('issue_date', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear()
        ]);
    }

    // Static methods for document management
    public static function getDocumentsByType($type, $employeeId = null)
    {
        $query = self::byDocumentType($type);
        
        if ($employeeId) {
            $query->byEmployee($employeeId);
        }

        return $query->orderBy('issue_date', 'desc')->get();
    }

    public static function getExpiringDocuments($days = 30)
    {
        return self::expiringSoon($days)
                  ->with('employee')
                  ->orderBy('expiry_date', 'asc')
                  ->get();
    }

    public static function getDocumentStatistics($employeeId = null)
    {
        $query = self::query();
        
        if ($employeeId) {
            $query->byEmployee($employeeId);
        }

        return [
            'total_documents' => $query->count(),
            'active_documents' => $query->clone()->active()->count(),
            'expired_documents' => $query->clone()->expired()->count(),
            'expiring_soon' => $query->clone()->expiringSoon()->count(),
            'draft_documents' => $query->clone()->byStatus('draft')->count(),
            'with_files' => $query->clone()->withFiles()->count(),
            'without_files' => $query->clone()->withoutFiles()->count(),
        ];
    }

    // Document validation methods
    public function isValidForUse()
    {
        return $this->is_active && !$this->is_expired;
    }

    public function needsRenewal($days = 30)
    {
        return $this->is_expiring_soon || $this->is_expired;
    }

    // File management methods
    public function getFileUrl()
    {
        if (!$this->has_file) {
            return null;
        }

        return asset('storage/' . $this->file_path);
    }

    public function deleteFile()
    {
        if ($this->has_file && file_exists(storage_path('app/public/' . $this->file_path))) {
            unlink(storage_path('app/public/' . $this->file_path));
        }
    }

    // Boot method for auto-updates
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($document) {
            // Auto-update data timestamp
            $document->data_updated_at = now();
            
            // Auto-update status based on expiry
            if ($document->expiry_date && Carbon::now()->gt($document->expiry_date)) {
                if ($document->document_status === 'aktif') {
                    $document->document_status = 'kadaluarsa';
                }
            }
        });

        static::deleting(function ($document) {
            // Delete associated file when document is deleted
            $document->deleteFile();
        });
    }
}
