<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\VaccineIn;
use App\Models\VaccineOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineReportController extends Controller
{
    public function index()
    {
        $vaccines = Vaccine::with('category')->orderBy('vaccine_name')->get();
        return view('pages.vaccine-report.index', compact('vaccines'));
    }

    public function reportStock(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccines,id'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vaccineId = $request->id_vaccine;

        $query = Vaccine::with('category');

        if ($vaccineId) {
            $query->where('id', $vaccineId);
        }

        $vaccines = $query->get()->map(function ($vaccine) use ($startDate, $endDate) {
            $totalIn = VaccineIn::where('id_vaccine', $vaccine->id)
                ->whereBetween('date_in', [$startDate, $endDate])
                ->sum('quantity');

            $totalOut = VaccineOut::where('id_vaccine', $vaccine->id)
                ->whereBetween('date_out', [$startDate, $endDate])
                ->sum('quantity');

            $vaccine->total_in = $totalIn;
            $vaccine->total_out = $totalOut;
            $vaccine->current_stock = $vaccine->stock;

            return $vaccine;
        });

        return view('pages.vaccine-report.stock', compact('vaccines', 'startDate', 'endDate'));
    }

    public function reportIn(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccines,id'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vaccineId = $request->id_vaccine;

        $query = VaccineIn::with('vaccine.category')
            ->whereBetween('date_in', [$startDate, $endDate]);

        if ($vaccineId) {
            $query->where('id_vaccine', $vaccineId);
        }

        $vaccineIns = $query->orderBy('date_in', 'desc')->get();

        $summary = [
            'total_quantity' => $vaccineIns->sum('quantity'),
            'total_value' => $vaccineIns->sum(function ($item) {
                return $item->quantity * $item->vaccine->price;
            }),
            'total_transactions' => $vaccineIns->count()
        ];

        return view('pages.vaccine-report.in', compact('vaccineIns', 'startDate', 'endDate', 'summary'));
    }

    public function reportOut(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccines,id'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vaccineId = $request->id_vaccine;

        $query = VaccineOut::with('vaccine.category')
            ->whereBetween('date_out', [$startDate, $endDate]);

        if ($vaccineId) {
            $query->where('id_vaccine', $vaccineId);
        }

        $vaccineOuts = $query->orderBy('date_out', 'desc')->get();

        $summary = [
            'total_quantity' => $vaccineOuts->sum('quantity'),
            'total_value' => $vaccineOuts->sum(function ($item) {
                return $item->quantity * $item->vaccine->price;
            }),
            'total_transactions' => $vaccineOuts->count()
        ];

        return view('pages.vaccine-report.out', compact('vaccineOuts', 'startDate', 'endDate', 'summary'));
    }
}
