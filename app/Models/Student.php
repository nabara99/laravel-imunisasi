<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name_student',
        'birth_date',
        'gender',
        'nik',
        'mother_name',
        'mother_nik',
        'id_school',
        'class'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
