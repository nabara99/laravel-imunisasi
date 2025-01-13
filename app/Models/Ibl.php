<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ibl extends Model
{
    /** @use HasFactory<\Database\Factories\IblFactory> */
    use HasFactory;

    protected $fillable = [
        'id_children',
        'pcv3',
        'penta4',
        'mr2',
        'lengkap',
    ];

    public function children()
    {
        return $this(BelongsTo::class);
    }
}
