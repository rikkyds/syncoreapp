<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
