<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idl extends Model
{
    /** @use HasFactory<\Database\Factories\IdlFactory> */
    use HasFactory;

    protected $fillable = [
        'id_children',
        'hb0',
        'bcg',
        'polio1',
        'penta1',
        'polio2',
        'pcv1',
        'rotavirus1',
        'penta2',
        'polio3',
        'pcv2',
        'rotavirus2',
        'penta3',
        'polio4',
        'ipv1',
        'rotavirus3',
        'mr1',
        'ipv2',
        'lengkap'
    ];

    public function children()
    {
        return $this->belongsTo(Children::class);
    }
}
