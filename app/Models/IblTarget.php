<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IblTarget extends Model
{
    /** @use HasFactory<\Database\Factories\IblTargetFactory> */
    use HasFactory;

    protected $fillable = [
        'sum_boys',
        'sum_girls',
        'village_id',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
