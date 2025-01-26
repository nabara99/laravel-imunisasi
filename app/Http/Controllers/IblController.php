<?php

namespace App\Http\Controllers;

use App\Models\Ibl;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IblController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ibls = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->select('ibls.*', 'childrens.name_child', 'childrens.nik', 'childrens.date_birth', 'childrens.gender', 'childrens.mother_name', 'villages.name')
            ->get();

        return view('pages.ibl.index', compact('ibls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $childrens = DB::table('childrens')
            ->select('*')
            ->whereRaw("TIMESTAMPDIFF(MONTH, date_birth, CURDATE()) BETWEEN ? AND ?", [12, 72])
            ->get();

        return view('pages.ibl.create', compact('childrens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id_children' => 'required|unique:ibls,id_children',
            ],
            [
                'id_children.unique' => 'Data anak sudah ada'
            ]
        );

        Ibl::create([
            'id_children' => $request->id_children,
            'pcv3' => $request->pcv3,
            'penta4' => $request->penta4,
            'mr2' => $request->mr2,
            'lengkap' => $request->lengkap
        ]);

        return redirect()->route('ibl-imun.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ibl $ibl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $childrens = Children::all();
        $ibl = Ibl::findOrFail($id);

        return view('pages.ibl.edit', compact('childrens', 'ibl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ibl = Ibl::findOrFail($id);

        $ibl->update([
            'id_children' => $request->id_children,
            'pcv3' => $request->pcv3,
            'penta4' => $request->penta4,
            'mr2' => $request->mr2,
            'lengkap' => $request->lengkap
        ]);

        return redirect()->route('ibl-imun.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ibl $ibl)
    {
        //
    }
}
