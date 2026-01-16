<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineOut extends Model
{
    protected $table = 'vaccine_out';

    protected $fillable = [
        'date_out',
        'id_vaccine',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'date_out' => 'date'
    ];

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'id_vaccine');
    }
}
