<?php

namespace App\Http\Controllers;

use App\Models\PharmacySale;
use App\Models\Patient;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacySaleController extends Controller
{
    public function index()
    {
        $sales = PharmacySale::with(['patient', 'items'])
            ->latest()
            ->paginate(20);
        return view('pharmacy.sales.index', compact('sales'));
    }

    public function create()
    {
        $patients = Patient::all();
        $medicines = InventoryItem::whereHas('category', function($query) {
                $query->where('type', 'medicine');
            })
            ->whereHas('stocks', function($query) {
                $query->where('quantity', '>', 0);
            })
            ->with('stocks')
            ->get();
        return view('pharmacy.sales.create', compact('patients', 'medicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'sale_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,insurance,transfer',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['quantity'] * $item['unit_price'];
            }

            $sale = PharmacySale::create([
                'patient_id' => $validated['patient_id'],
                'sale_date' => $validated['sale_date'],
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
            ]);

            foreach ($validated['items'] as $item) {
                $sale->items()->create([
                    'inventory_item_id' => $item['inventory_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);

                // Update inventory stock
                $inventoryItem = InventoryItem::find($item['inventory_item_id']);
                $remainingQuantity = $item['quantity'];
                
                // Deduct from stocks (FIFO - First In First Out)
                foreach ($inventoryItem->stocks()->where('quantity', '>', 0)->oldest()->get() as $stock) {
                    if ($remainingQuantity <= 0) break;
                    
                    if ($stock->quantity >= $remainingQuantity) {
                        $stock->decrement('quantity', $remainingQuantity);
                        $remainingQuantity = 0;
                    } else {
                        $remainingQuantity -= $stock->quantity;
                        $stock->update(['quantity' => 0]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('pharmacy-sales.show', $sale)
                ->with('success', 'Sale completed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Error processing sale: ' . $e->getMessage());
        }
    }

    public function show(PharmacySale $pharmacySale)
    {
        $pharmacySale->load(['patient', 'items.inventoryItem']);
        return view('pharmacy.sales.show', compact('pharmacySale'));
    }

    public function destroy(PharmacySale $pharmacySale)
    {
        $pharmacySale->delete();
        return redirect()->route('pharmacy-sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
