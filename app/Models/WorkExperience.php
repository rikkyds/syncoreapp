<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'industry',
        'position',
        'main_responsibilities',
        'start_date',
        'end_date',
        'is_current',
        'employment_status',
        'location',
        'is_remote',
        'salary',
        'salary_currency',
        'leaving_reason',
        'reference_name',
        'reference_position',
        'reference_contact',
        'reference_email',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_remote' => 'boolean',
        'salary' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
