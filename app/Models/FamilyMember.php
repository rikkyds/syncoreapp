<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'relationship',
        'other_relationship',
        'birth_place',
        'birth_date',
        'gender',
        'is_alive',
        'death_date',
        'education_level',
        'occupation',
        'is_financial_dependent',
        'marital_status',
        'is_emergency_contact',
        'phone_number',
        'email',
        'address'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'is_alive' => 'boolean',
        'is_financial_dependent' => 'boolean',
        'is_emergency_contact' => 'boolean'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getRelationshipTextAttribute(): string
    {
        if ($this->relationship === 'other') {
            return $this->other_relationship;
        }

        return match ($this->relationship) {
            'father' => 'Ayah',
            'mother' => 'Ibu',
            'spouse' => 'Suami/Istri',
            'child' => 'Anak',
            'sibling' => 'Saudara Kandung',
            'grandfather' => 'Kakek',
            'grandmother' => 'Nenek',
            'father_in_law' => 'Ayah Mertua',
            'mother_in_law' => 'Ibu Mertua',
            default => ucfirst(str_replace('_', ' ', $this->relationship))
        };
    }

    public function getEducationLevelTextAttribute(): ?string
    {
        if (!$this->education_level) {
            return null;
        }

        return match ($this->education_level) {
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'smk' => 'SMK',
            'd1' => 'D1',
            'd2' => 'D2',
            'd3' => 'D3',
            'd4' => 'D4',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
            default => ucfirst($this->education_level)
        };
    }

    public function getMaritalStatusTextAttribute(): ?string
    {
        if (!$this->marital_status) {
            return null;
        }

        return match ($this->marital_status) {
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorced' => 'Cerai',
            'widowed' => 'Janda/Duda',
            default => ucfirst($this->marital_status)
        };
    }
}
