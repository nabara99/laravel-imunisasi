<?php

namespace App\Services;

use App\Models\Vaccine;
use App\Models\VaccineIn;
use App\Models\VaccineOut;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class VaccineStockReport
{
    public function get(string $startDate, string $endDate, ?int $vaccineId = null): Collection
    {
        $startDate = Carbon::parse($startDate)->toDateString();
        $endDate = Carbon::parse($endDate)->toDateString();
        $stocks = Vaccine::with('category')->withVvm()->orderBy('id')->get();
        $receipts = VaccineIn::with('category')->orderBy('date_in')->orderBy('id')->get();
        $issuesByVaccine = VaccineOut::whereDate('date_out', '<=', $endDate)->get()->groupBy('id_vaccine');

        // The schema has no receipt foreign key. Match batches without mixing
        // different packaging, expiry dates, or unit prices.
        $batchKey = fn ($row) => json_encode([
            $row->vaccine_name,
            (int) $row->id_category_vaccine,
            $row->batch_number,
            $row->expired_date->toDateString(),
            (int) $row->price,
        ], JSON_THROW_ON_ERROR);
        $stocksByBatch = $stocks->groupBy($batchKey);
        $receiptsByBatch = $receipts->groupBy($batchKey);
        $keys = $stocksByBatch->keys()->merge($receiptsByBatch->keys())->unique();

        if ($vaccineId) {
            $selected = $stocks->firstWhere('id', $vaccineId);
            $keys = $selected ? collect([$batchKey($selected)]) : collect();
        }

        return $keys->map(function ($key) use ($stocksByBatch, $receiptsByBatch, $issuesByVaccine, $startDate, $endDate) {
            $batchStocks = $stocksByBatch->get($key, collect());
            $batchReceipts = $receiptsByBatch->get($key, collect());
            $batchIssues = $batchStocks->flatMap(fn ($stock) => $issuesByVaccine->get($stock->id, collect()));

            if ($batchStocks->isNotEmpty()) {
                $row = clone $batchStocks->first();
            } else {
                // A historical receipt must remain visible even without a stock row.
                $receipt = $batchReceipts->last();
                $row = new Vaccine($receipt->only([
                    'vaccine_name', 'id_category_vaccine', 'batch_number',
                    'expired_date', 'price', 'date_in',
                ]));
                $row->setRelation('category', $receipt->category);
                $row->vvm = $receipt->vvm;
            }

            $openingIn = $batchReceipts->filter(fn ($receipt) => $receipt->date_in->toDateString() < $startDate)->sum('stock');
            $openingOut = $batchIssues->filter(fn ($issue) => $issue->date_out->toDateString() < $startDate)->sum('quantity');
            $row->opening_stock = $openingIn - $openingOut;
            $row->total_in = $batchReceipts->filter(fn ($receipt) => $receipt->date_in->toDateString() >= $startDate
                && $receipt->date_in->toDateString() <= $endDate)->sum('stock');
            $row->total_out = $batchIssues->filter(fn ($issue) => $issue->date_out->toDateString() >= $startDate)->sum('quantity');
            $row->closing_stock = $row->opening_stock + $row->total_in - $row->total_out;
            $row->current_stock = $batchStocks->sum('stock');
            $row->stock = $row->current_stock;

            return $row;
        })->values();
    }
}
