<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    /** @use HasFactory<\Database\Factories\ChildrenFactory> */
    use HasFactory;

    protected $fillable = [
        'name_child',
        'nik',
        'date_birth',
        'mother_name',
        'mother_nik',
        'address',
        'gender',
        'id_village',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
