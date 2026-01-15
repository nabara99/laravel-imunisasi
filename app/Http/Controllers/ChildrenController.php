<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $childrens = DB::table('childrens')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->select('childrens.*', 'villages.name')
            ->get();

        return view('pages.children.index', compact('childrens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();

        return view('pages.children.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_child' => 'required',
            'nik' => 'required|max:16|min:16|unique:childrens,nik',
            'date_birth' => 'required',
            'mother_name' => 'required',
            'mother_nik' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'id_village' => 'required',
        ]);

        Children::create($validated);

        return redirect()->route('children.index')->with('success', 'Data anak berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Children $children)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $children = Children::findOrFail($id);
        $villages = Village::all();

        return view('pages.children.edit', compact('children', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $children = Children::findOrFail($id);

        $validated = $request->validate([
            'name_child' => 'required',
            'nik' => 'required|max:16|min:16',
            'date_birth' => 'required',
            'mother_name' => 'required',
            'mother_nik' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'id_village' => 'required',
        ]);

        $children->update($validated);

        return redirect()->route('children.index')->with('success', 'Data anak berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $children = Children::findOrFail($id);
        $children->delete();

        return redirect()->route('children.index')->with('success', 'Data anak berhasil dihapus');
    }
}
