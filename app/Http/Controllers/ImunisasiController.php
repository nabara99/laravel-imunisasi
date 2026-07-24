<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImunisasiController extends Controller
{
    public function index(Request $request)
    {
        $month  = $request->input('month');  // format: YYYY-MM
        $search = $request->input('search');
        $tab    = $request->input('tab', 'idl');

        $year     = null;
        $monthNum = null;
        if ($month) {
            [$year, $monthNum] = explode('-', $month);
        }

        $idls  = $this->queryIdl($search, $year, $monthNum);
        $ibls  = $this->queryIbl($search, $year, $monthNum);
        $bias  = $this->queryBias($search, $year, $monthNum);
        $wus   = $this->queryWus($search, $year, $monthNum, false);
        $bumil = $this->queryWus($search, $year, $monthNum, true);

        return view('pages.imunisasi.index', compact(
            'idls', 'ibls', 'bias', 'wus', 'bumil', 'month', 'search', 'tab'
        ));
    }

    private function queryIdl($search, $year, $monthNum)
    {
        $query = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->select(
                'idls.*',
                'childrens.name_child',
                'childrens.nik',
                'childrens.date_birth',
                'childrens.gender',
                'childrens.mother_name',
                'villages.name as village_name'
            );

        if ($search) {
            $query->where('childrens.name_child', 'like', '%' . $search . '%');
        }

        if ($year && $monthNum) {
            $fields = ['hb0', 'bcg', 'polio1', 'penta1', 'polio2', 'pcv1', 'rotavirus1',
                       'penta2', 'polio3', 'pcv2', 'rotavirus2', 'penta3', 'polio4',
                       'ipv1', 'rotavirus3', 'mr1', 'ipv2'];
            $query->where(function ($q) use ($fields, $year, $monthNum) {
                foreach ($fields as $field) {
                    $q->orWhere(function ($sub) use ($field, $year, $monthNum) {
                        $sub->whereYear("idls.{$field}", $year)
                            ->whereMonth("idls.{$field}", $monthNum);
                    });
                }
            });
        }

        return $query->orderBy('childrens.name_child')->get();
    }

    private function queryIbl($search, $year, $monthNum)
    {
        $query = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->select(
                'ibls.*',
                'childrens.name_child',
                'childrens.nik',
                'childrens.date_birth',
                'childrens.gender',
                'childrens.mother_name',
                'villages.name as village_name'
            );

        if ($search) {
            $query->where('childrens.name_child', 'like', '%' . $search . '%');
        }

        if ($year && $monthNum) {
            $fields = ['pcv3', 'penta4', 'mr2'];
            $query->where(function ($q) use ($fields, $year, $monthNum) {
                foreach ($fields as $field) {
                    $q->orWhere(function ($sub) use ($field, $year, $monthNum) {
                        $sub->whereYear("ibls.{$field}", $year)
                            ->whereMonth("ibls.{$field}", $monthNum);
                    });
                }
            });
        }

        return $query->orderBy('childrens.name_child')->get();
    }

    private function queryBias($search, $year, $monthNum)
    {
        $query = DB::table('student_imuns')
            ->join('students', 'student_imuns.id_student', '=', 'students.id')
            ->join('schools', 'students.id_school', '=', 'schools.id')
            ->select(
                'student_imuns.*',
                'students.name_student',
                'students.nik',
                'students.gender',
                'students.class',
                'schools.name as school_name'
            );

        if ($search) {
            $query->where('students.name_student', 'like', '%' . $search . '%');
        }

        if ($year && $monthNum) {
            $fields = ['dt', 'mr', 'td1', 'td2pa', 'td2pi', 'hpv1', 'hpv2'];
            $query->where(function ($q) use ($fields, $year, $monthNum) {
                foreach ($fields as $field) {
                    $q->orWhere(function ($sub) use ($field, $year, $monthNum) {
                        $sub->whereYear("student_imuns.{$field}", $year)
                            ->whereMonth("student_imuns.{$field}", $monthNum);
                    });
                }
            });
        }

        return $query->orderBy('students.name_student')->get();
    }

    private function queryWus($search, $year, $monthNum, bool $hamil)
    {
        $query = DB::table('wus_imuns')
            ->join('wuses', 'wus_imuns.id_wus', '=', 'wuses.id')
            ->join('villages', 'wuses.id_village', '=', 'villages.id')
            ->where('wuses.hamil', $hamil ? 1 : 0)
            ->select(
                'wus_imuns.*',
                'wuses.name_wus',
                'wuses.nik',
                'wuses.date_birth',
                'villages.name as village_name'
            );

        if ($search) {
            $query->where('wuses.name_wus', 'like', '%' . $search . '%');
        }

        if ($year && $monthNum) {
            $fields = ['t1', 't2', 't3', 't4', 't5'];
            $query->where(function ($q) use ($fields, $year, $monthNum) {
                foreach ($fields as $field) {
                    $q->orWhere(function ($sub) use ($field, $year, $monthNum) {
                        $sub->whereYear("wus_imuns.{$field}", $year)
                            ->whereMonth("wus_imuns.{$field}", $monthNum);
                    });
                }
            });
        }

        return $query->orderBy('wuses.name_wus')->get();
    }
}
