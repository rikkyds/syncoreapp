<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchOffice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function workUnits()
    {
        return $this->hasMany(WorkUnit::class);
    }
}
