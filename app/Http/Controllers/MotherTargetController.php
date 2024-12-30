<?php

namespace App\Http\Controllers;

use App\Models\MotherTarget;
use App\Http\Requests\StoreMotherTargetRequest;
use App\Http\Requests\UpdateMotherTargetRequest;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotherTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motherTargets = DB::table('mother_targets')
        ->join('villages', 'mother_targets.village_id', '=', 'villages.id')
        ->select('mother_targets.*', 'villages.name')
        ->get();

        return view('pages.mother-target.index', compact('motherTargets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();
        return view('pages.mother-target.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pregnant' => 'required',
            'no_pregnant' => 'required',
            'village_id' => 'required',
        ]);

        MotherTarget::create($validated);

        return redirect()->route('mother-target.index')->with('success', 'Data Sasaran WUS berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MotherTarget $motherTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $motherTarget = MotherTarget::findOrFail($id);
        $villages = Village::all();

        return view('pages.mother-target.edit', compact('motherTarget', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $motherTarget = MotherTarget::findOrFail($id);

        $validated = $request->validate([
            'pregnant' => 'required',
            'no_pregnant' => 'required',
            'village_id' => 'required',
        ]);

        $motherTarget->update($validated);

        return redirect()->route('mother-target.index')->with('success', 'Data Sasaran WUS berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotherTarget $motherTarget)
    {
        //
    }
}
