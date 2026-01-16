<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportIDL = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('idl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'idl_targets.village_id')
                     ->whereBetween('idl_targets.year', [$startYear, $endYear]);
            })
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
            ->groupBy('villages.id', 'villages.name', 'idl_targets.sum_boys', 'idl_targets.sum_girls')
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

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportIBL = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('ibl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'ibl_targets.village_id')
                     ->whereBetween('ibl_targets.year', [$startYear, $endYear]);
            })
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
            ->groupBy('villages.id', 'villages.name', 'ibl_targets.sum_boys', 'ibl_targets.sum_girls')
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input lebih awal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportTT = DB::table('wus_imuns')
            ->join('wuses', 'wus_imuns.id_wus', '=', 'wuses.id')
            ->join('villages', 'wuses.id_village', '=', 'villages.id')
            ->join('mother_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'mother_targets.village_id')
                     ->whereBetween('mother_targets.year', [$startYear, $endYear]);
            })
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
            ->groupBy('villages.id', 'villages.name', 'mother_targets.no_pregnant', 'mother_targets.pregnant')
            ->orderBy('villages.id')
            ->setBindings(array_fill(0, 10, [$startDate, $endDate]))
            ->get();

        return view('pages.report.reportTT', [
            'reportTT' => $reportTT,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function reportBIAS(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportBIAS = DB::table('student_targets')
            ->join('schools', 'student_targets.id_school', '=', 'schools.id')
            ->leftJoin('students', 'schools.id', '=', 'students.id_school')
            ->leftJoin('student_imuns', 'students.id', '=', 'student_imuns.id_student')
            ->whereBetween('student_targets.year', [$startYear, $endYear])
            ->select(
                'schools.name as school_name',
                'student_targets.classroom',
                'student_targets.sum_boys',
                'student_targets.sum_girls',
                DB::raw('COUNT(DISTINCT students.id) AS total_students'),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv1 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_hpv1"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv1 BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_hpv1"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv2 BETWEEN '{$startDate}' AND '{$endDate}' THEN 1 ELSE 0 END) AS total_hpv2"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv2 BETWEEN '{$startDate}' AND '{$endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_hpv2")
            )
            ->groupBy('schools.id', 'schools.name', 'student_targets.classroom', 'student_targets.sum_boys', 'student_targets.sum_girls', 'student_targets.year')
            ->orderBy('schools.id')
            ->get();

        return view('pages.report.reportBias', [
            'reportBias' => $reportBIAS,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function reportIDLExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportIDL = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('idl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'idl_targets.village_id')
                     ->whereBetween('idl_targets.year', [$startYear, $endYear]);
            })
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
            ->groupBy('villages.id', 'villages.name', 'idl_targets.sum_boys', 'idl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();

        // Create Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Common style for headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']]
        ];

        $currentRow = 1;

        // ========== TABLE 1: MR DAN IDL (IMUNISASI LENGKAP) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP MR DAN IDL PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header row 1
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'Imunisasi Lengkap');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        // Header row 2
        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);
            $sheet->setCellValue('E' . $currentRow, $report->boys_complete);
            $sheet->setCellValue('F' . $currentRow, $report->girls_complete);
            $sheet->setCellValue('G' . $currentRow, $report->complete);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->complete / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_complete'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_complete'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('complete'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('complete') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 2: HB0 ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP HB0 PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header row 1
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'HB0');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        // Header row 2
        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);
            $sheet->setCellValue('E' . $currentRow, $report->boys_hb0);
            $sheet->setCellValue('F' . $currentRow, $report->girls_hb0);
            $sheet->setCellValue('G' . $currentRow, $report->total_hb0);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_hb0 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_hb0'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_hb0'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_hb0'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_hb0') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 3: BCG ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP BCG PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header row 1
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'BCG');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        // Header row 2
        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);
            $sheet->setCellValue('E' . $currentRow, $report->boys_bcg);
            $sheet->setCellValue('F' . $currentRow, $report->girls_bcg);
            $sheet->setCellValue('G' . $currentRow, $report->total_bcg);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_bcg / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_bcg'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_bcg'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_bcg'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_bcg') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 4: POLIO (POLIO 1-4) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP POLIO PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':T' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':T' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header row 1
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'POLIO 1');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'POLIO 2');
        $sheet->mergeCells('I' . $currentRow . ':L' . $currentRow);
        $sheet->setCellValue('M' . $currentRow, 'POLIO 3');
        $sheet->mergeCells('M' . $currentRow . ':P' . $currentRow);
        $sheet->setCellValue('Q' . $currentRow, 'POLIO 4');
        $sheet->mergeCells('Q' . $currentRow . ':T' . $currentRow);

        $currentRow++;

        // Header row 2
        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        // POLIO 1
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');
        // POLIO 2
        $sheet->setCellValue('I' . $currentRow, 'L');
        $sheet->setCellValue('J' . $currentRow, 'P');
        $sheet->setCellValue('K' . $currentRow, 'JLH');
        $sheet->setCellValue('L' . $currentRow, '%');
        // POLIO 3
        $sheet->setCellValue('M' . $currentRow, 'L');
        $sheet->setCellValue('N' . $currentRow, 'P');
        $sheet->setCellValue('O' . $currentRow, 'JLH');
        $sheet->setCellValue('P' . $currentRow, '%');
        // POLIO 4
        $sheet->setCellValue('Q' . $currentRow, 'L');
        $sheet->setCellValue('R' . $currentRow, 'P');
        $sheet->setCellValue('S' . $currentRow, 'JLH');
        $sheet->setCellValue('T' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':T' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            // POLIO 1
            $sheet->setCellValue('E' . $currentRow, $report->boys_polio1);
            $sheet->setCellValue('F' . $currentRow, $report->girls_polio1);
            $sheet->setCellValue('G' . $currentRow, $report->total_polio1);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_polio1 / $totalBabies) * 100, 2) : 0);

            // POLIO 2
            $sheet->setCellValue('I' . $currentRow, $report->boys_polio2);
            $sheet->setCellValue('J' . $currentRow, $report->girls_polio2);
            $sheet->setCellValue('K' . $currentRow, $report->total_polio2);
            $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($report->total_polio2 / $totalBabies) * 100, 2) : 0);

            // POLIO 3
            $sheet->setCellValue('M' . $currentRow, $report->boys_polio3);
            $sheet->setCellValue('N' . $currentRow, $report->girls_polio3);
            $sheet->setCellValue('O' . $currentRow, $report->total_polio3);
            $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($report->total_polio3 / $totalBabies) * 100, 2) : 0);

            // POLIO 4
            $sheet->setCellValue('Q' . $currentRow, $report->boys_polio4);
            $sheet->setCellValue('R' . $currentRow, $report->girls_polio4);
            $sheet->setCellValue('S' . $currentRow, $report->total_polio4);
            $sheet->setCellValue('T' . $currentRow, $totalBabies > 0 ? number_format(($report->total_polio4 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_polio1'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_polio1'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_polio1'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_polio1') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('I' . $currentRow, $reportIDL->sum('boys_polio2'));
        $sheet->setCellValue('J' . $currentRow, $reportIDL->sum('girls_polio2'));
        $sheet->setCellValue('K' . $currentRow, $reportIDL->sum('total_polio2'));
        $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_polio2') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('M' . $currentRow, $reportIDL->sum('boys_polio3'));
        $sheet->setCellValue('N' . $currentRow, $reportIDL->sum('girls_polio3'));
        $sheet->setCellValue('O' . $currentRow, $reportIDL->sum('total_polio3'));
        $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_polio3') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('Q' . $currentRow, $reportIDL->sum('boys_polio4'));
        $sheet->setCellValue('R' . $currentRow, $reportIDL->sum('girls_polio4'));
        $sheet->setCellValue('S' . $currentRow, $reportIDL->sum('total_polio4'));
        $sheet->setCellValue('T' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_polio4') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':T' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':T' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 2: DPT-HB-HIB/PENTBIO (DPT-HB-HIB 1-3) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP DPT-HB-HIB/PENTBIO PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':P' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':P' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'DPT-HB-HIB 1');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'DPT-HB-HIB 2');
        $sheet->mergeCells('I' . $currentRow . ':L' . $currentRow);
        $sheet->setCellValue('M' . $currentRow, 'DPT-HB-HIB 3');
        $sheet->mergeCells('M' . $currentRow . ':P' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        // DPT-HB-HIB 1
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');
        // DPT-HB-HIB 2
        $sheet->setCellValue('I' . $currentRow, 'L');
        $sheet->setCellValue('J' . $currentRow, 'P');
        $sheet->setCellValue('K' . $currentRow, 'JLH');
        $sheet->setCellValue('L' . $currentRow, '%');
        // DPT-HB-HIB 3
        $sheet->setCellValue('M' . $currentRow, 'L');
        $sheet->setCellValue('N' . $currentRow, 'P');
        $sheet->setCellValue('O' . $currentRow, 'JLH');
        $sheet->setCellValue('P' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':P' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            // PENTA 1
            $sheet->setCellValue('E' . $currentRow, $report->boys_penta1);
            $sheet->setCellValue('F' . $currentRow, $report->girls_penta1);
            $sheet->setCellValue('G' . $currentRow, $report->total_penta1);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_penta1 / $totalBabies) * 100, 2) : 0);

            // PENTA 2
            $sheet->setCellValue('I' . $currentRow, $report->boys_penta2);
            $sheet->setCellValue('J' . $currentRow, $report->girls_penta2);
            $sheet->setCellValue('K' . $currentRow, $report->total_penta2);
            $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($report->total_penta2 / $totalBabies) * 100, 2) : 0);

            // PENTA 3
            $sheet->setCellValue('M' . $currentRow, $report->boys_penta3);
            $sheet->setCellValue('N' . $currentRow, $report->girls_penta3);
            $sheet->setCellValue('O' . $currentRow, $report->total_penta3);
            $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($report->total_penta3 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_penta1'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_penta1'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_penta1'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_penta1') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('I' . $currentRow, $reportIDL->sum('boys_penta2'));
        $sheet->setCellValue('J' . $currentRow, $reportIDL->sum('girls_penta2'));
        $sheet->setCellValue('K' . $currentRow, $reportIDL->sum('total_penta2'));
        $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_penta2') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('M' . $currentRow, $reportIDL->sum('boys_penta3'));
        $sheet->setCellValue('N' . $currentRow, $reportIDL->sum('girls_penta3'));
        $sheet->setCellValue('O' . $currentRow, $reportIDL->sum('total_penta3'));
        $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_penta3') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':P' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':P' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 6: IPV (IPV 1-2) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP IPV PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'IPV 1');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'IPV 2');
        $sheet->mergeCells('I' . $currentRow . ':L' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        // IPV 1
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');
        // IPV 2
        $sheet->setCellValue('I' . $currentRow, 'L');
        $sheet->setCellValue('J' . $currentRow, 'P');
        $sheet->setCellValue('K' . $currentRow, 'JLH');
        $sheet->setCellValue('L' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':L' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            // IPV 1
            $sheet->setCellValue('E' . $currentRow, $report->boys_ipv1);
            $sheet->setCellValue('F' . $currentRow, $report->girls_ipv1);
            $sheet->setCellValue('G' . $currentRow, $report->total_ipv1);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_ipv1 / $totalBabies) * 100, 2) : 0);

            // IPV 2
            $sheet->setCellValue('I' . $currentRow, $report->boys_ipv2);
            $sheet->setCellValue('J' . $currentRow, $report->girls_ipv2);
            $sheet->setCellValue('K' . $currentRow, $report->total_ipv2);
            $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($report->total_ipv2 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_ipv1'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_ipv1'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_ipv1'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_ipv1') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('I' . $currentRow, $reportIDL->sum('boys_ipv2'));
        $sheet->setCellValue('J' . $currentRow, $reportIDL->sum('girls_ipv2'));
        $sheet->setCellValue('K' . $currentRow, $reportIDL->sum('total_ipv2'));
        $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_ipv2') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':L' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 7: PCV (PCV 1-2) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP PCV PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'PCV 1');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'PCV 2');
        $sheet->mergeCells('I' . $currentRow . ':L' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        // PCV 1
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');
        // PCV 2
        $sheet->setCellValue('I' . $currentRow, 'L');
        $sheet->setCellValue('J' . $currentRow, 'P');
        $sheet->setCellValue('K' . $currentRow, 'JLH');
        $sheet->setCellValue('L' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':L' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            // PCV 1
            $sheet->setCellValue('E' . $currentRow, $report->boys_pcv1);
            $sheet->setCellValue('F' . $currentRow, $report->girls_pcv1);
            $sheet->setCellValue('G' . $currentRow, $report->total_pcv1);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_pcv1 / $totalBabies) * 100, 2) : 0);

            // PCV 2
            $sheet->setCellValue('I' . $currentRow, $report->boys_pcv2);
            $sheet->setCellValue('J' . $currentRow, $report->girls_pcv2);
            $sheet->setCellValue('K' . $currentRow, $report->total_pcv2);
            $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($report->total_pcv2 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_pcv1'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_pcv1'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_pcv1'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_pcv1') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('I' . $currentRow, $reportIDL->sum('boys_pcv2'));
        $sheet->setCellValue('J' . $currentRow, $reportIDL->sum('girls_pcv2'));
        $sheet->setCellValue('K' . $currentRow, $reportIDL->sum('total_pcv2'));
        $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_pcv2') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':L' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ========== TABLE 8: ROTAVIRUS (ROTAVIRUS 1-3) ==========
        $sheet->setCellValue('A' . $currentRow, 'REKAP ROTAVIRUS PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':P' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':P' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Header
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, 'ROTAVIRUS 1');
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'ROTAVIRUS 2');
        $sheet->mergeCells('I' . $currentRow . ':L' . $currentRow);
        $sheet->setCellValue('M' . $currentRow, 'ROTAVIRUS 3');
        $sheet->mergeCells('M' . $currentRow . ':P' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        // ROTAVIRUS 1
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');
        // ROTAVIRUS 2
        $sheet->setCellValue('I' . $currentRow, 'L');
        $sheet->setCellValue('J' . $currentRow, 'P');
        $sheet->setCellValue('K' . $currentRow, 'JLH');
        $sheet->setCellValue('L' . $currentRow, '%');
        // ROTAVIRUS 3
        $sheet->setCellValue('M' . $currentRow, 'L');
        $sheet->setCellValue('N' . $currentRow, 'P');
        $sheet->setCellValue('O' . $currentRow, 'JLH');
        $sheet->setCellValue('P' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':P' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            // ROTAVIRUS 1
            $sheet->setCellValue('E' . $currentRow, $report->boys_rotavirus1);
            $sheet->setCellValue('F' . $currentRow, $report->girls_rotavirus1);
            $sheet->setCellValue('G' . $currentRow, $report->total_rotavirus1);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_rotavirus1 / $totalBabies) * 100, 2) : 0);

            // ROTAVIRUS 2
            $sheet->setCellValue('I' . $currentRow, $report->boys_rotavirus2);
            $sheet->setCellValue('J' . $currentRow, $report->girls_rotavirus2);
            $sheet->setCellValue('K' . $currentRow, $report->total_rotavirus2);
            $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($report->total_rotavirus2 / $totalBabies) * 100, 2) : 0);

            // ROTAVIRUS 3
            $sheet->setCellValue('M' . $currentRow, $report->boys_rotavirus3);
            $sheet->setCellValue('N' . $currentRow, $report->girls_rotavirus3);
            $sheet->setCellValue('O' . $currentRow, $report->total_rotavirus3);
            $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($report->total_rotavirus3 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIDL->sum('sum_boys');
        $totalGirls = $reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIDL->sum('boys_rotavirus1'));
        $sheet->setCellValue('F' . $currentRow, $reportIDL->sum('girls_rotavirus1'));
        $sheet->setCellValue('G' . $currentRow, $reportIDL->sum('total_rotavirus1'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_rotavirus1') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('I' . $currentRow, $reportIDL->sum('boys_rotavirus2'));
        $sheet->setCellValue('J' . $currentRow, $reportIDL->sum('girls_rotavirus2'));
        $sheet->setCellValue('K' . $currentRow, $reportIDL->sum('total_rotavirus2'));
        $sheet->setCellValue('L' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_rotavirus2') / $totalBabies) * 100, 2) : 0);
        $sheet->setCellValue('M' . $currentRow, $reportIDL->sum('boys_rotavirus3'));
        $sheet->setCellValue('N' . $currentRow, $reportIDL->sum('girls_rotavirus3'));
        $sheet->setCellValue('O' . $currentRow, $reportIDL->sum('total_rotavirus3'));
        $sheet->setCellValue('P' . $currentRow, $totalBabies > 0 ? number_format(($reportIDL->sum('total_rotavirus3') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':P' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':P' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Auto size columns
        foreach (range('A', 'T') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_IDL_' . date('Y-m-d', strtotime($startDate)) . '_to_' . date('Y-m-d', strtotime($endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function reportIBLExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Determine years from date range
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));

        $reportIBL = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('ibl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'ibl_targets.village_id')
                     ->whereBetween('ibl_targets.year', [$startYear, $endYear]);
            })
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
            ->groupBy('villages.id', 'villages.name', 'ibl_targets.sum_boys', 'ibl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();

        // Create Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Styles
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $currentRow = 1;

        // ==================== TABLE 1: PCV 3 ====================
        $sheet->setCellValue('A' . $currentRow, 'REKAP PVC 3 PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->setCellValue('E' . $currentRow, 'PCV 3');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIBL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            $sheet->setCellValue('E' . $currentRow, $report->boys_pcv3);
            $sheet->setCellValue('F' . $currentRow, $report->girls_pcv3);
            $sheet->setCellValue('G' . $currentRow, $report->total_pcv3);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_pcv3 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIBL->sum('sum_boys');
        $totalGirls = $reportIBL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIBL->sum('boys_pcv3'));
        $sheet->setCellValue('F' . $currentRow, $reportIBL->sum('girls_pcv3'));
        $sheet->setCellValue('G' . $currentRow, $reportIBL->sum('total_pcv3'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIBL->sum('total_pcv3') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ==================== TABLE 2: DPT-HB-HIB 4 ====================
        $sheet->setCellValue('A' . $currentRow, 'REKAP DPT-HB-HIB 4 PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->setCellValue('E' . $currentRow, 'DPT-HB-HIB 4');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIBL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            $sheet->setCellValue('E' . $currentRow, $report->boys_penta4);
            $sheet->setCellValue('F' . $currentRow, $report->girls_penta4);
            $sheet->setCellValue('G' . $currentRow, $report->total_penta4);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_penta4 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIBL->sum('sum_boys');
        $totalGirls = $reportIBL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIBL->sum('boys_penta4'));
        $sheet->setCellValue('F' . $currentRow, $reportIBL->sum('girls_penta4'));
        $sheet->setCellValue('G' . $currentRow, $reportIBL->sum('total_penta4'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIBL->sum('total_penta4') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;

        // ==================== TABLE 3: MR 2 ====================
        $sheet->setCellValue('A' . $currentRow, 'REKAP MR 2 PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($startDate)) . ' s.d ' . date('j F Y', strtotime($endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->setCellValue('E' . $currentRow, 'MR 2');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);

        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);

        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($reportIBL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);

            $sheet->setCellValue('E' . $currentRow, $report->boys_mr2);
            $sheet->setCellValue('F' . $currentRow, $report->girls_mr2);
            $sheet->setCellValue('G' . $currentRow, $report->total_mr2);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->total_mr2 / $totalBabies) * 100, 2) : 0);

            $currentRow++;
        }

        // Total row
        $totalBoys = $reportIBL->sum('sum_boys');
        $totalGirls = $reportIBL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $reportIBL->sum('boys_mr2'));
        $sheet->setCellValue('F' . $currentRow, $reportIBL->sum('girls_mr2'));
        $sheet->setCellValue('G' . $currentRow, $reportIBL->sum('total_mr2'));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($reportIBL->sum('total_mr2') / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Auto size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_IBL_' . date('Y-m-d', strtotime($startDate)) . '_to_' . date('Y-m-d', strtotime($endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
