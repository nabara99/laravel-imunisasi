<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class, 'id_category_vaccine');
    }
}
