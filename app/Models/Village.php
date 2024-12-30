<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    /** @use HasFactory<\Database\Factories\VillageFactory> */
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function children()
    {
        return $this->hasMany(Children::class);
    }

    public function idlTarget()
    {
        return $this->hasMany(IdlTarget::class);
    }

    public function iblTarget()
    {
        return $this->hasMany(IdlTarget::class);
    }
}
