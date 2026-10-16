<?php

namespace App\Http\Controllers;

use App\Exports\VaccineInExport;
use App\Exports\VaccineOutExport;
use App\Exports\VaccineStockExport;
use App\Models\Vaccine;
use App\Models\VaccineIn;
use App\Models\VaccineOut;
use App\Services\VaccineStockReport;
use Illuminate\Http\Request;

class VaccineReportController extends Controller
{
    public function index()
    {
        $vaccineIns = VaccineIn::orderBy('vaccine_name')->get();
        $vaccines = Vaccine::orderBy('vaccine_name')->get();

        return view('pages.vaccine-report.index', compact('vaccineIns', 'vaccines'));
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

        $vaccines = app(VaccineStockReport::class)->get($startDate, $endDate, $vaccineId);

        return view('pages.vaccine-report.stock', compact('vaccines', 'startDate', 'endDate'));
    }

    public function reportStockExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccines,id'
        ]);

        $exporter = new VaccineStockExport($request->start_date, $request->end_date, $request->id_vaccine);
        return $exporter->download();
    }

    public function reportIn(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccine_in,id'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vaccineId = $request->id_vaccine;

        $query = VaccineIn::with('category')
            ->whereBetween('date_in', [$startDate, $endDate]);

        if ($vaccineId) {
            $query->where('id', $vaccineId);
        }

        $vaccineIns = $query->orderBy('date_in', 'desc')->get();

        $summary = [
            'total_quantity' => $vaccineIns->sum('stock'),
            'total_value' => $vaccineIns->sum(function ($item) {
                return $item->stock * $item->price;
            }),
            'total_transactions' => $vaccineIns->count()
        ];

        return view('pages.vaccine-report.in', compact('vaccineIns', 'startDate', 'endDate', 'summary'));
    }

    public function reportInExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccine_in,id'
        ]);

        $exporter = new VaccineInExport($request->start_date, $request->end_date, $request->id_vaccine);
        return $exporter->download();
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
                return $item->quantity * ($item->vaccine ? $item->vaccine->price : 0);
            }),
            'total_transactions' => $vaccineOuts->count()
        ];

        return view('pages.vaccine-report.out', compact('vaccineOuts', 'startDate', 'endDate', 'summary'));
    }

    public function reportOutExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id_vaccine' => 'nullable|exists:vaccines,id'
        ]);

        $exporter = new VaccineOutExport($request->start_date, $request->end_date, $request->id_vaccine);
        return $exporter->download();
    }
}
