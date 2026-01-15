<?php

namespace App\Http\Controllers;

use App\Models\IblTarget;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IblTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->get('year', 2026);

        // Get available years from database
        $availableYears = DB::table('ibl_targets')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();

        // Ensure 2025 and 2026 are in the list
        if (!in_array(2025, $availableYears)) {
            $availableYears[] = 2025;
        }
        if (!in_array(2026, $availableYears)) {
            $availableYears[] = 2026;
        }
        sort($availableYears);

        $iblTargets = DB::table('ibl_targets')
            ->join('villages', 'ibl_targets.village_id', '=', 'villages.id')
            ->select('ibl_targets.*', 'villages.name')
            ->where('ibl_targets.year', $year)
            ->get();

        $sumBoys = DB::table('ibl_targets')->where('year', $year)->sum('sum_boys');
        $sumGirls = DB::table('ibl_targets')->where('year', $year)->sum('sum_girls');

        return view('pages.ibl-target.index', compact('iblTargets', 'sumBoys', 'sumGirls', 'year', 'availableYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();
        return view('pages.ibl-target.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sum_boys' => 'required',
            'sum_girls' => 'required',
            'village_id' => 'required',
        ]);

        // Auto-set year to 2026 for new records
        $validated['year'] = 2026;

        IblTarget::create($validated);

        return redirect()->route('ibl-target.index', ['year' => 2026])->with('success', 'Data Sasaran berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(IblTarget $iblTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $iblTarget = IblTarget::findOrFail($id);
        $villages = Village::all();

        return view('pages.ibl-target.edit', compact('iblTarget', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $iblTarget = IblTarget::findOrFail($id);

        $validated = $request->validate([
            'sum_boys' => 'required',
            'sum_girls' => 'required',
            'village_id' => 'required',
        ]);

        $iblTarget->update($validated);

        return redirect()->route('ibl-target.index')->with('success', 'Data Sasaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IblTarget $iblTarget)
    {
        //
    }
}
