<?php

namespace App\Http\Controllers;

use App\Models\Idl;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idls = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->select('idls.*', 'childrens.name_child', 'childrens.nik', 'childrens.date_birth', 'childrens.gender', 'childrens.mother_name', 'villages.name')
            ->get();

        return view('pages.idl.index', compact('idls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $childrens = DB::table('childrens')
        //     ->select('*')
        //     ->whereRaw("TIMESTAMPDIFF(MONTH, date_birth, CURDATE()) < ?", 24)
        //     ->get();

        $childrens = Children::all();

        return view('pages.idl.create', compact('childrens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id_children' => 'required|unique:idls,id_children',
            ],
            [
                'id_children.unique' => 'Data bayi sudah ada'
            ]
        );

        Idl::create([
            'id_children' => $request->id_children,
            'hb0' => $request->hb0,
            'bcg' => $request->bcg,
            'polio1' => $request->polio1,
            'penta1' => $request->penta1,
            'polio2' => $request->polio2,
            'pcv1' => $request->pcv1,
            'rotavirus1' => $request->rotavirus1,
            'penta2' => $request->penta2,
            'polio3' => $request->polio3,
            'pcv2' => $request->pcv2,
            'rotavirus2' => $request->rotavirus2,
            'penta3' => $request->penta3,
            'polio4' => $request->polio4,
            'ipv1' => $request->ipv1,
            'rotavirus3' => $request->rotavirus3,
            'mr1' => $request->mr1,
            'ipv2' => $request->ipv2,
            'lengkap' => $request->lengkap
        ]);

        return redirect()->route('idl-imun.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idl $idl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $childrens = Children::all();
        $idl = Idl::findOrFail($id);

        return view('pages.idl.edit', compact('childrens', 'idl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $idl = Idl::findOrFail($id);

        $idl->update([
            'id_children' => $request->id_children,
            'hb0' => $request->hb0,
            'bcg' => $request->bcg,
            'polio1' => $request->polio1,
            'penta1' => $request->penta1,
            'polio2' => $request->polio2,
            'pcv1' => $request->pcv1,
            'rotavirus1' => $request->rotavirus1,
            'penta2' => $request->penta2,
            'polio3' => $request->polio3,
            'pcv2' => $request->pcv2,
            'rotavirus2' => $request->rotavirus2,
            'penta3' => $request->penta3,
            'polio4' => $request->polio4,
            'ipv1' => $request->ipv1,
            'rotavirus3' => $request->rotavirus3,
            'mr1' => $request->mr1,
            'ipv2' => $request->ipv2,
            'lengkap' => $request->lengkap
        ]);

        return redirect()->route('idl-imun.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idl $idl)
    {
        //
    }
}
