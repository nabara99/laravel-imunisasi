<?php

namespace App\Http\Controllers;

use App\Models\WusImun;
use App\Models\Wus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WusImunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wuses = DB::table('wus_imuns')
            ->join('wuses', 'wus_imuns.id_wus', '=', 'wuses.id')
            ->join('villages', 'wuses.id_village', '=', 'villages.id')
            ->select('wus_imuns.*', 'wuses.name_wus', 'wuses.nik', 'wuses.date_birth', 'wuses.hamil', 'villages.name')
            ->get();

        return view('pages.tt.index', compact('wuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wuses = Wus::all();

        return view('pages.tt.create', compact('wuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_wus' => 'required|unique:wus_imuns,id_wus',
        ], [
            'id_wus.unique' => 'Data sudah ada',
        ]);

        WusImun::create([
            'id_wus' => $request->id_wus,
            't1' => $request->t1,
            't1_status' => $request->t1_status,
            't2' => $request->t2,
            't2_status' => $request->t2_status,
            't3' => $request->t3,
            't3_status' => $request->t3_status,
            't4' => $request->t4,
            't4_status' => $request->t4_status,
            't5' => $request->t5,
            't5_status' => $request->t5_status,
        ]);

        return redirect()->route('tt-imun.index')->with('success', 'Data TT berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(WusImun $wusImun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tt = WusImun::findOrFail($id);
        $wuses = Wus::all();

        return view('pages.tt.edit', compact('tt', 'wuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tt = WusImun::findOrFail($id);

        $tt->update([
            'id_wus' => $request->id_wus,
            't1' => $request->t1,
            't1_status' => $request->t1_status,
            't2' => $request->t2,
            't2_status' => $request->t2_status,
            't3' => $request->t3,
            't3_status' => $request->t3_status,
            't4' => $request->t4,
            't4_status' => $request->t4_status,
            't5' => $request->t5,
            't5_status' => $request->t5_status,
        ]);

        return redirect()->route('tt-imun.index')->with('success', 'Data TT berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WusImun $wusImun)
    {
        //
    }
}
