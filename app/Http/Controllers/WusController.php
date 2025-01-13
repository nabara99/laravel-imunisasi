<?php

namespace App\Http\Controllers;

use App\Models\Wus;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wuses = DB::table('wuses')
        ->join('villages', 'wuses.id_village', '=', 'villages.id')
        ->select('wuses.*', 'villages.name')
        ->get();

        return view('pages.wus.index', compact('wuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();

        return view('pages.wus.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_wus' => 'required',
            'nik' => 'required|max:16|min:16|unique:wuses,nik',
            'date_birth' => 'required',
            'address' => 'required',
            'id_village' => 'required',
            'hamil' => 'required',
        ], [
            'nik.unique' => 'Nik sudah terpakai'
        ]);

        Wus::create($validated);

        return redirect()->route('wus.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wus $wus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $wus = Wus::findOrFail($id);
        $villages = Village::all();

        return view('pages.wus.edit', compact('wus', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $wus = Wus::findOrFail($id);

        $validated = $request->validate([
            'name_wus' => 'required',
            'nik' => 'required|max:16|min:16',
            'date_birth' => 'required',
            'address' => 'required',
            'id_village' => 'required',
            'hamil' => 'required',
        ]);

        $wus->update($validated);

        return redirect()->route('wus.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wus $wus)
    {
        //
    }
}
