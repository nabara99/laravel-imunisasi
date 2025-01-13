<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wus extends Model
{
    /** @use HasFactory<\Database\Factories\WusFactory> */
    use HasFactory;

    protected $fillable = [
        'name_wus',
        'nik',
        'date_birth',
        'address',
        'id_village',
        'hamil'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function wusImun()
    {
        return $this->belongsTo(WusImun::class);
    }
}
