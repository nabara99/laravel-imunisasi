<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.report.index');
    }

    public function reportIDL(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $reportIDL = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('idl_targets', 'villages.id', '=', 'idl_targets.village_id')
            ->select(
                'villages.name as village_name',
                'idl_targets.sum_boys',
                'idl_targets.sum_girls',
                DB::raw('COUNT(DISTINCT childrens.id) AS total_children'),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS complete"),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_complete"),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_complete"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_hb0"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_hb0"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_hb0")
            )
            ->groupBy('villages.name', 'idl_targets.sum_boys', 'idl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();

        return view('pages.report.reportIdl', [
            'reportIdl' => $reportIDL,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
