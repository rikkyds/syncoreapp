<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Personal Information
        'full_name',
        'profile_photo',
        'nik',
        'ktp_photo',
        'birth_place',
        'birth_date',
        'gender',
        'marital_status',
        'address',
        'phone_number',
        'personal_email',
        
        // Insurance & Financial Information
        'bpjs_health',
        'bpjs_health_photo',
        'bpjs_employment',
        'bank_account',
        'bank_name',
        'npwp',
        'npwp_photo',
        
        // Company Information
        'employee_id',
        'work_unit_id',
        'position_id',
        'employment_status',
        'join_date',
        
        // Relations
        'company_id',
        'branch_office_id',
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'employee_skills')
            ->withPivot('proficiency_level', 'notes', 'certificate')
            ->withTimestamps();
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class)->orderBy('is_current', 'desc')->orderBy('end_date', 'desc');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(FamilyMember::class)->where('is_emergency_contact', true);
    }

    public function leaves()
    {
        return $this->hasMany(EmployeeLeave::class);
    }

    public function shifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function allowances()
    {
        return $this->hasMany(EmployeeAllowance::class);
    }

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function attendances()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }
}
