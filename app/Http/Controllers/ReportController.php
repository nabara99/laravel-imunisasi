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
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_hb0"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_bcg"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_bcg"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_bcg"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_polio4"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio4"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio4"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_penta3"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta3"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta3"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_ipv2"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_ipv2"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_ipv2"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_pcv2"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv2"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_rotavirus3"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus3"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus3"),
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

    public function reportIBL(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $reportIBL = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('ibl_targets', 'villages.id', '=', 'ibl_targets.village_id')
            ->select(
                'villages.name as village_name',
                'ibl_targets.sum_boys',
                'ibl_targets.sum_girls',
                DB::raw('COUNT(DISTINCT childrens.id) AS total_children'),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_penta4"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta4"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta4"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_mr2"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_mr2"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$startDate}' AND '{$endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_mr2"),
            )
            ->groupBy('villages.name', 'ibl_targets.sum_boys', 'ibl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();

        return view('pages.report.reportIbl', [
            'reportIbl' => $reportIBL,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function reportTT(Request $request)
    {
        // Validasi input lebih awal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reportTT = DB::table('wus_imuns')
            ->join('wuses', 'wus_imuns.id_wus', '=', 'wuses.id')
            ->join('villages', 'wuses.id_village', '=', 'villages.id')
            ->join('mother_targets', 'villages.id', '=', 'mother_targets.village_id')
            ->select(
                'villages.name as village_name',
                'mother_targets.no_pregnant',
                'mother_targets.pregnant',
            )
            ->addSelect([
                DB::raw("COUNT(CASE WHEN wus_imuns.t1 BETWEEN ? AND ? AND wus_imuns.t1_status = '1' THEN 1 END) AS t1_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t1 BETWEEN ? AND ? AND wus_imuns.t1_status = '0' THEN 1 END) AS t1_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t2 BETWEEN ? AND ? AND wus_imuns.t2_status = '1' THEN 1 END) AS t2_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t2 BETWEEN ? AND ? AND wus_imuns.t2_status = '0' THEN 1 END) AS t2_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t3 BETWEEN ? AND ? AND wus_imuns.t3_status = '1' THEN 1 END) AS t3_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t3 BETWEEN ? AND ? AND wus_imuns.t3_status = '0' THEN 1 END) AS t3_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t4 BETWEEN ? AND ? AND wus_imuns.t4_status = '1' THEN 1 END) AS t4_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t4 BETWEEN ? AND ? AND wus_imuns.t4_status = '0' THEN 1 END) AS t4_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t5 BETWEEN ? AND ? AND wus_imuns.t5_status = '1' THEN 1 END) AS t5_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t5 BETWEEN ? AND ? AND wus_imuns.t5_status = '0' THEN 1 END) AS t5_no_pregnant")
            ])
            ->groupBy('villages.name', 'mother_targets.no_pregnant', 'mother_targets.pregnant')
            ->orderBy('villages.id')
            ->setBindings(array_fill(0, 10, [$startDate, $endDate]))
            ->get();

        return view('pages.report.reportTT', [
            'reportTT' => $reportTT,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
