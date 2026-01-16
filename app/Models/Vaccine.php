<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'vaccine_name',
        'id_category_vaccine',
        'price',
        'batch_number',
        'expired_date',
        'stock'
    ];

    protected $casts = [
        'expired_date' => 'date'
    ];

    public function category()
    {
        return $this->belongsTo(VaccineCategory::class, 'id_category_vaccine');
    }

    public function vaccineIns()
    {
        return $this->hasMany(VaccineIn::class, 'id_vaccine');
    }

    public function vaccineOuts()
    {
        return $this->hasMany(VaccineOut::class, 'id_vaccine');
    }
}
