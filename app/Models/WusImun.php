<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WusImun extends Model
{
    /** @use HasFactory<\Database\Factories\WusImunFactory> */
    use HasFactory;

    protected $fillable = [
        'id_wus',
        't1',
        't1_status',
        't2',
        't2_status',
        't3',
        't3_status',
        't4',
        't4_status',
        't5',
        't5_status',
    ];

    public function wus()
    {
        return $this->belongsTo(Wus::class);
    }
}
