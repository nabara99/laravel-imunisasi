<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\VaccineCategory;
use App\Models\VaccineIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineInController extends Controller
{
    public function index()
    {
        $vaccineIns = VaccineIn::with('category')
            ->latest('date_in')
            ->get();

        $categories = VaccineCategory::all();

        return view('pages.vaccine-in.index', compact('vaccineIns', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'id_category_vaccine' => 'required|exists:vaccine_categories,id',
            'batch_number' => 'required|string|max:255',
            'expired_date' => 'required|date|after:today',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'date_in' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // Create vaccine_in record
            $vaccineIn = VaccineIn::create([
                'vaccine_name' => $request->vaccine_name,
                'id_category_vaccine' => $request->id_category_vaccine,
                'price' => $request->price,
                'batch_number' => $request->batch_number,
                'expired_date' => $request->expired_date,
                'stock' => $request->quantity,
                'date_in' => $request->date_in,
                'notes' => $request->notes
            ]);

            // Create vaccine record (same data without notes)
            Vaccine::create([
                'vaccine_name' => $request->vaccine_name,
                'id_category_vaccine' => $request->id_category_vaccine,
                'price' => $request->price,
                'batch_number' => $request->batch_number,
                'expired_date' => $request->expired_date,
                'stock' => $request->quantity,
                'date_in' => $request->date_in
            ]);
        });

        return redirect()->route('vaccine-in.index')
            ->with('success', 'Vaksin berhasil ditambahkan ke stok');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'id_category_vaccine' => 'required|exists:vaccine_categories,id',
            'batch_number' => 'required|string|max:255',
            'expired_date' => 'required|date|after:today',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'date_in' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $id) {
            $vaccineIn = VaccineIn::findOrFail($id);

            // Find corresponding vaccine record based on old data
            $vaccine = Vaccine::where('vaccine_name', $vaccineIn->vaccine_name)
                ->where('batch_number', $vaccineIn->batch_number)
                ->where('date_in', $vaccineIn->date_in)
                ->first();

            // Update vaccine_in record
            $vaccineIn->update([
                'vaccine_name' => $request->vaccine_name,
                'id_category_vaccine' => $request->id_category_vaccine,
                'price' => $request->price,
                'batch_number' => $request->batch_number,
                'expired_date' => $request->expired_date,
                'stock' => $request->quantity,
                'date_in' => $request->date_in,
                'notes' => $request->notes
            ]);

            // Update vaccine record if found
            if ($vaccine) {
                $vaccine->update([
                    'vaccine_name' => $request->vaccine_name,
                    'id_category_vaccine' => $request->id_category_vaccine,
                    'price' => $request->price,
                    'batch_number' => $request->batch_number,
                    'expired_date' => $request->expired_date,
                    'stock' => $request->quantity,
                    'date_in' => $request->date_in
                ]);
            }
        });

        return redirect()->route('vaccine-in.index')
            ->with('success', 'Data penerimaan vaksin berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $vaccineIn = VaccineIn::findOrFail($id);

                // Find corresponding vaccine record
                $vaccine = Vaccine::where('vaccine_name', $vaccineIn->vaccine_name)
                    ->where('batch_number', $vaccineIn->batch_number)
                    ->where('date_in', $vaccineIn->date_in)
                    ->first();

                // Delete vaccine in record
                $vaccineIn->delete();

                // Delete corresponding vaccine record if found
                if ($vaccine) {
                    $vaccine->delete();
                }
            });

            return redirect()->route('vaccine-in.index')
                ->with('success', 'Data penerimaan vaksin berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('vaccine-in.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
