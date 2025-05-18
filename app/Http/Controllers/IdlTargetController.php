<?php

namespace App\Http\Controllers;

use App\Models\IdlTarget;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdlTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idlTargets = DB::table('idl_targets')
        ->join('villages', 'idl_targets.village_id', '=', 'villages.id')
        ->select('idl_targets.*', 'villages.name')
        ->get();

        $sumBoys = DB::table('idl_targets')->sum('sum_boys');
        $sumGirls = DB::table('idl_targets')->sum('sum_girls');

        return view('pages.idl-target.index', compact('idlTargets', 'sumBoys', 'sumGirls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();
        return view('pages.idl-target.create', compact('villages'));
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

        IdlTarget::create($validated);

        return redirect()->route('idl-target.index')->with('success', 'Data Sasaran berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(IdlTarget $idlTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $idlTarget = IdlTarget::findOrFail($id);
        $villages = Village::all();

        return view('pages.idl-target.edit', compact('idlTarget', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $idlTarget = IdlTarget::findOrFail($id);

        $validated = $request->validate([
            'sum_boys' => 'required',
            'sum_girls' => 'required',
            'village_id' => 'required',
        ]);

        $idlTarget->update($validated);

        return redirect()->route('idl-target.index')->with('success', 'Data Sasaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IdlTarget $idlTarget)
    {
        //
    }
}
