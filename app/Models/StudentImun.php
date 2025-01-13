<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentImun extends Model
{
    /** @use HasFactory<\Database\Factories\StudentImumFactory> */
    use HasFactory;

    protected $fillable = [
        'id_student',
        'dt',
        'mr',
        'td1',
        'td2pa',
        'td2pi',
        'hpv1',
        'hpv2',
    ];
}
