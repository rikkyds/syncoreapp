<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_office_id',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }
}
