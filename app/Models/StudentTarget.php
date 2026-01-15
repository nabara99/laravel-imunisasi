<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTarget extends Model
{
    /** @use HasFactory<\Database\Factories\StudentTargetFactory> */
    use HasFactory;

    protected $fillable = [
        'id_school',
        'classroom',
        'sum_boys',
        'sum_girls',
        'year',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
