<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\VaccineOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineOutController extends Controller
{
    public function index()
    {
        $vaccineOuts = VaccineOut::with('vaccine.category')
            ->latest('date_out')
            ->get();

        $vaccines = Vaccine::where('stock', '>', 0)->get();

        return view('pages.vaccine-out.index', compact('vaccineOuts', 'vaccines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_out' => 'required|date',
            'id_vaccine' => 'required|exists:vaccines,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $vaccine = Vaccine::findOrFail($request->id_vaccine);

                // Check stock availability
                if ($vaccine->stock < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $vaccine->stock);
                }

                // Create vaccine out record
                VaccineOut::create([
                    'date_out' => $request->date_out,
                    'id_vaccine' => $request->id_vaccine,
                    'quantity' => $request->quantity,
                    'notes' => $request->notes
                ]);

                // Decrease stock
                $vaccine->decrement('stock', $request->quantity);
            });

            return redirect()->route('vaccine-out.index')
                ->with('success', 'Pengeluaran vaksin berhasil dicatat');
        } catch (\Exception $e) {
            return redirect()->route('vaccine-out.index')
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'date_out' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $vaccineOut = VaccineOut::findOrFail($id);
                $vaccine = $vaccineOut->vaccine;
                $oldQuantity = $vaccineOut->quantity;
                $newQuantity = $request->quantity;
                $difference = $newQuantity - $oldQuantity;

                // Check if stock is sufficient for the change
                if ($difference > 0 && $vaccine->stock < $difference) {
                    throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $vaccine->stock);
                }

                // Update vaccine out
                $vaccineOut->update([
                    'date_out' => $request->date_out,
                    'quantity' => $newQuantity,
                    'notes' => $request->notes
                ]);

                // Adjust stock
                if ($difference != 0) {
                    $vaccine->decrement('stock', $difference);
                }
            });

            return redirect()->route('vaccine-out.index')
                ->with('success', 'Data pengeluaran vaksin berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('vaccine-out.index')
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $vaccineOut = VaccineOut::findOrFail($id);
                $vaccine = $vaccineOut->vaccine;

                // Return stock
                $vaccine->increment('stock', $vaccineOut->quantity);

                // Delete vaccine out record
                $vaccineOut->delete();
            });

            return redirect()->route('vaccine-out.index')
                ->with('success', 'Data pengeluaran vaksin berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('vaccine-out.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
