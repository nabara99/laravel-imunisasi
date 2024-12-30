<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotherTarget extends Model
{
    /** @use HasFactory<\Database\Factories\MotherTargetFactory> */
    use HasFactory;

    protected $fillable = [
        'pregnant',
        'no_pregnant',
        'village_id',
    ];
}
