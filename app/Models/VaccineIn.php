<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineIn extends Model
{
    protected $table = 'vaccine_in';

    protected $fillable = [
        'vaccine_name',
        'id_category_vaccine',
        'price',
        'batch_number',
        'expired_date',
        'stock',
        'date_in',
        'notes'
    ];

    protected $casts = [
        'expired_date' => 'date',
        'date_in' => 'date'
    ];

    public function category()
    {
        return $this->belongsTo(VaccineCategory::class, 'id_category_vaccine');
    }
}
