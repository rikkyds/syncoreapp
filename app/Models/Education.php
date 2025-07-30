<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'educations';

    protected $fillable = [
        'employee_id',
        'education_level_id',
        'institution_name',
        'major',
        'city',
        'country',
        'start_year',
        'end_year',
        'degree',
        'status',
        'gpa',
        'certificate'
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer',
        'gpa' => 'float'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
