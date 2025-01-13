<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function studentTarget()
    {
        return $this->hasMany(StudentTarget::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
