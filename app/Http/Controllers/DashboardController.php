<?php

namespace App\Http\Controllers;

use App\Models\Ibl;
use App\Models\IblTarget;
use App\Models\Idl;
use App\Models\IdlTarget;
use App\Models\MotherTarget;
use App\Models\StudentImun;
use App\Models\StudentTarget;
use App\Models\WusImun;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const DOSE_DATES = [
        'idls' => ['mr1'],
        'ibls' => ['mr2'],
        'wus_imuns' => ['t1', 't2', 't3', 't4', 't5'],
        'student_imuns' => ['dt', 'mr', 'td1', 'td2pa', 'td2pi', 'hpv1', 'hpv2'],
    ];

    public function index(Request $request)
    {
        $validated = $request->validate(['year' => 'nullable|integer|between:1900,9999']);
        $dashboardYear = (int) ($validated['year'] ?? now()->year);
        $dashboardYears = $this->availableYears($dashboardYear);

        // 1. IDL Statistics
        $idlTargetTotal = (int) IdlTarget::where('year', $dashboardYear)->sum(DB::raw('sum_boys + sum_girls'));
        $idlAchievement = Idl::where('lengkap', 1)->whereYear('mr1', $dashboardYear)->distinct()->count('id_children');
        $idlPercentage = $idlTargetTotal > 0 ? round(($idlAchievement / $idlTargetTotal) * 100, 1) : 0;

        // 2. IBL Statistics
        $iblTargetTotal = (int) IblTarget::where('year', $dashboardYear)->sum(DB::raw('sum_boys + sum_girls'));
        $iblAchievement = Ibl::where('lengkap', 1)->whereYear('mr2', $dashboardYear)->distinct()->count('id_children');
        $iblPercentage = $iblTargetTotal > 0 ? round(($iblAchievement / $iblTargetTotal) * 100, 1) : 0;

        // 3. WUS/TT Statistics
        $wusTargetTotal = (int) MotherTarget::where('year', $dashboardYear)->sum(DB::raw('pregnant + no_pregnant'));
        $ttAchievement = $this->annualRecipients(WusImun::query(), self::DOSE_DATES['wus_imuns'], 'id_wus', $dashboardYear);
        $ttPercentage = $wusTargetTotal > 0 ? round(($ttAchievement / $wusTargetTotal) * 100, 1) : 0;

        // 4. BIAS Statistics
        $biasTargetTotal = (int) StudentTarget::where('year', $dashboardYear)->sum(DB::raw('sum_boys + sum_girls'));
        $biasAchievement = $this->annualRecipients(StudentImun::query(), self::DOSE_DATES['student_imuns'], 'id_student', $dashboardYear);
        $biasPercentage = $biasTargetTotal > 0 ? round(($biasAchievement / $biasTargetTotal) * 100, 1) : 0;

        return view('dashboard', compact(
            'dashboardYear', 'dashboardYears',
            'idlTargetTotal', 'idlAchievement', 'idlPercentage',
            'iblTargetTotal', 'iblAchievement', 'iblPercentage',
            'wusTargetTotal', 'ttAchievement', 'ttPercentage',
            'biasTargetTotal', 'biasAchievement', 'biasPercentage'
        ));
    }

    private function annualRecipients(Builder $query, array $dateColumns, string $recipientColumn, int $year): int
    {
        return $query->where(function (Builder $query) use ($dateColumns, $year) {
            foreach ($dateColumns as $column) {
                $query->orWhereYear($column, $year);
            }
        })->distinct()->count($recipientColumn);
    }

    private function availableYears(int $selectedYear): array
    {
        $query = DB::table('idl_targets')->select('year');
        foreach (['ibl_targets', 'mother_targets', 'student_targets'] as $table) {
            $query->union(DB::table($table)->select('year'));
        }

        foreach (self::DOSE_DATES as $table => $columns) {
            foreach ($columns as $column) {
                $query->union(DB::table($table)->whereNotNull($column)->selectRaw("SUBSTR({$column}, 1, 4) as year"));
            }
        }

        return $query->pluck('year')->push(now()->year, $selectedYear)
            ->filter(fn ($year) => is_numeric($year) && $year >= 1900 && $year <= 9999)
            ->map(fn ($year) => (int) $year)->unique()->sortDesc()->values()->all();
    }
}
