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
    public function index()
    {
        $iblTargets = DB::table('ibl_targets')
        ->join('villages', 'ibl_targets.village_id', '=', 'villages.id')
        ->select('ibl_targets.*', 'villages.name')
        ->get();

        $sumBoys = DB::table('ibl_targets')->sum('sum_boys');
        $sumGirls = DB::table('ibl_targets')->sum('sum_girls');

        return view('pages.ibl-target.index', compact('iblTargets', 'sumBoys', 'sumGirls'));
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

        IblTarget::create($validated);

        return redirect()->route('ibl-target.index')->with('success', 'Data Sasaran berhasil disimpan');
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
