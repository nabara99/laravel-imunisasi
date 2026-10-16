<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'vaccine_name',
        'id_category_vaccine',
        'price',
        'batch_number',
        'expired_date',
        'stock',
        'date_in',
    ];

    protected $casts = [
        'expired_date' => 'date',
        'date_in' => 'date'
    ];

    public function scopeWithVvm(Builder $query): Builder
    {
        return $query->addSelect([
            'vvm' => VaccineIn::query()->select('vvm')
                ->whereColumn('vaccine_in.vaccine_name', 'vaccines.vaccine_name')
                ->whereColumn('vaccine_in.batch_number', 'vaccines.batch_number')
                ->whereColumn('vaccine_in.id_category_vaccine', 'vaccines.id_category_vaccine')
                ->orderByDesc('date_in')
                ->orderByDesc('id')
                ->limit(1),
        ]);
    }

    public function category()
    {
        return $this->belongsTo(VaccineCategory::class, 'id_category_vaccine');
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expired_date->lt(today());
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return !$this->is_expired && $this->expired_date->lte(today()->addDays(30));
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->is_expired) {
            return 'Kadaluarsa';
        }

        if ($this->is_expiring_soon) {
            return 'Segera Kadaluarsa';
        }

        return $this->stock == 0 ? 'Habis' : 'Tersedia';
    }

    public function vaccineOuts()
    {
        return $this->hasMany(VaccineOut::class, 'id_vaccine');
    }
}
