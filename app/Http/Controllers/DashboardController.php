<?php

namespace App\Http\Controllers;

use App\Models\Idl;
use App\Models\IdlTarget;
use App\Models\Ibl;
use App\Models\IblTarget;
use App\Models\WusImun;
use App\Models\MotherTarget;
use App\Models\StudentImun;
use App\Models\StudentTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. IDL Statistics
        $idlTarget = IdlTarget::selectRaw('SUM(sum_boys + sum_girls) as total')->first();
        $idlAchievement = Idl::where('lengkap', 1)->count();
        $idlTargetTotal = $idlTarget->total ?? 0;
        $idlPercentage = $idlTargetTotal > 0 ? round(($idlAchievement / $idlTargetTotal) * 100, 1) : 0;

        // 2. IBL Statistics
        $iblTarget = IblTarget::selectRaw('SUM(sum_boys + sum_girls) as total')->first();
        $iblAchievement = Ibl::where('lengkap', 1)->count();
        $iblTargetTotal = $iblTarget->total ?? 0;
        $iblPercentage = $iblTargetTotal > 0 ? round(($iblAchievement / $iblTargetTotal) * 100, 1) : 0;

        // 3. WUS/TT Statistics
        $wusTarget = MotherTarget::selectRaw('SUM(pregnant + no_pregnant) as total')->first();
        // Count WUS with at least T1 (minimal requirement for TT)
        $ttAchievement = WusImun::whereNotNull('t1')->count();
        $wusTargetTotal = $wusTarget->total ?? 0;
        $ttPercentage = $wusTargetTotal > 0 ? round(($ttAchievement / $wusTargetTotal) * 100, 1) : 0;

        // 4. BIAS Statistics
        $biasTarget = StudentTarget::selectRaw('SUM(sum_boys + sum_girls) as total')->first();
        // Count students with at least one vaccine (DT, MR, TD1, TD2PA, TD2PI, HPV1, or HPV2)
        $biasAchievement = StudentImun::whereNotNull(DB::raw("COALESCE(dt, mr, td1, td2pa, td2pi, hpv1, hpv2)"))->count();
        $biasTargetTotal = $biasTarget->total ?? 0;
        $biasPercentage = $biasTargetTotal > 0 ? round(($biasAchievement / $biasTargetTotal) * 100, 1) : 0;

        return view('dashboard', compact(
            'idlTargetTotal', 'idlAchievement', 'idlPercentage',
            'iblTargetTotal', 'iblAchievement', 'iblPercentage',
            'wusTargetTotal', 'ttAchievement', 'ttPercentage',
            'biasTargetTotal', 'biasAchievement', 'biasPercentage'
        ));
    }
}
