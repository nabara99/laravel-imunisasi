<?php

namespace App\Http\Controllers;

use App\Models\VaccineCategory;
use Illuminate\Http\Request;

class VaccineCategoryController extends Controller
{
    public function index()
    {
        $categories = VaccineCategory::latest()->get();
        return view('pages.vaccine-category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vaccine_categories,name'
        ]);

        VaccineCategory::create(['name' => $request->name]);

        return redirect()->route('vaccine-category.index')
            ->with('success', 'Kategori kemasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vaccine_categories,name,' . $id
        ]);

        $category = VaccineCategory::findOrFail($id);
        $category->update(['name' => $request->name]);

        return redirect()->route('vaccine-category.index')
            ->with('success', 'Kategori kemasan berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            $category = VaccineCategory::findOrFail($id);
            $category->delete();

            return redirect()->route('vaccine-category.index')
                ->with('success', 'Kategori kemasan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('vaccine-category.index')
                ->with('error', 'Kategori kemasan tidak dapat dihapus karena masih digunakan');
        }
    }
}
