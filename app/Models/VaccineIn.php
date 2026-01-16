<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineIn extends Model
{
    protected $table = 'vaccine_in';

    protected $fillable = [
        'date_in',
        'id_vaccine',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'date_in' => 'date'
    ];

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'id_vaccine');
    }
}
