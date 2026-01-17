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
        $vaccineIns = VaccineIn::with('vaccine.category')
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
            // Create or update vaccine
            $vaccine = Vaccine::firstOrCreate(
                [
                    'vaccine_name' => $request->vaccine_name,
                    'batch_number' => $request->batch_number,
                ],
                [
                    'id_category_vaccine' => $request->id_category_vaccine,
                    'price' => $request->price,
                    'expired_date' => $request->expired_date,
                    'stock' => 0
                ]
            );

            // Create vaccine in record
            VaccineIn::create([
                'date_in' => $request->date_in,
                'id_vaccine' => $vaccine->id,
                'quantity' => $request->quantity,
                'notes' => $request->notes
            ]);

            // Update stock
            $vaccine->increment('stock', $request->quantity);
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
            $vaccine = $vaccineIn->vaccine;
            $oldQuantity = $vaccineIn->quantity;
            $newQuantity = $request->quantity;
            $difference = $newQuantity - $oldQuantity;

            // Update vaccine data
            $vaccine->update([
                'vaccine_name' => $request->vaccine_name,
                'id_category_vaccine' => $request->id_category_vaccine,
                'batch_number' => $request->batch_number,
                'expired_date' => $request->expired_date,
                'price' => $request->price
            ]);

            // Update vaccine in
            $vaccineIn->update([
                'date_in' => $request->date_in,
                'quantity' => $newQuantity,
                'notes' => $request->notes
            ]);

            // Adjust stock if quantity changed
            if ($difference != 0) {
                $vaccine->increment('stock', $difference);
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
                $vaccine = $vaccineIn->vaccine;

                // Check if stock is sufficient
                if ($vaccine->stock < $vaccineIn->quantity) {
                    throw new \Exception('Stok tidak mencukupi untuk menghapus data ini');
                }

                // Decrease stock
                $vaccine->decrement('stock', $vaccineIn->quantity);

                // Delete vaccine in record
                $vaccineIn->delete();

                // If vaccine has no more stock and no history, delete it
                if ($vaccine->stock == 0 && $vaccine->vaccineIns()->count() == 0 && $vaccine->vaccineOuts()->count() == 0) {
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
