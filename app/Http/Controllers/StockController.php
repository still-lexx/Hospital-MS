<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display stock overview
     */
    public function index()
    {
        $items = InventoryItem::with(['category', 'stocks'])
            ->withSum('stocks', 'quantity')
            ->get()
            ->map(function ($item) {
                $item->total_quantity = $item->stocks_sum_quantity ?? 0;
                $item->is_low_stock = $item->total_quantity <= $item->reorder_level;
                return $item;
            });

        return view('inventory.stock.index', compact('items'));
    }

    /**
     * Show stock adjustment form
     */
    public function adjust(InventoryItem $item)
    {
        $item->load(['category', 'stocks']);
        $currentStock = $item->stocks()->sum('quantity');
        
        return view('inventory.stock.adjust', compact('item', 'currentStock'));
    }

    /**
     * Store stock adjustment
     */
    public function storeAdjustment(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:100',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $currentStock = $item->stocks()->sum('quantity');
            $adjustmentQuantity = $validated['quantity'];

            // Calculate the actual change in quantity
            switch ($validated['adjustment_type']) {
                case 'add':
                    $movementQuantity = $adjustmentQuantity;
                    $movementType = 'in';
                    
                    // Create or update stock record
                    Stock::create([
                        'inventory_item_id' => $item->id,
                        'quantity' => $adjustmentQuantity,
                        'location' => $validated['location'] ?? null,
                        'batch_number' => $validated['batch_number'] ?? null,
                        'expiry_date' => $validated['expiry_date'] ?? null,
                    ]);
                    break;

                case 'subtract':
                    $movementQuantity = $adjustmentQuantity;
                    $movementType = 'out';
                    
                    // Reduce stock from existing records
                    $this->reduceStock($item, $adjustmentQuantity);
                    break;

                case 'set':
                    // Calculate the difference
                    $difference = $adjustmentQuantity - $currentStock;
                    $movementQuantity = abs($difference);
                    $movementType = $difference >= 0 ? 'in' : 'out';
                    
                    if ($difference > 0) {
                        // Add stock
                        Stock::create([
                            'inventory_item_id' => $item->id,
                            'quantity' => $difference,
                            'location' => $validated['location'] ?? null,
                            'batch_number' => $validated['batch_number'] ?? null,
                            'expiry_date' => $validated['expiry_date'] ?? null,
                        ]);
                    } elseif ($difference < 0) {
                        // Reduce stock
                        $this->reduceStock($item, abs($difference));
                    }
                    break;
            }

            // Record the movement
            if (isset($movementQuantity) && $movementQuantity > 0) {
                StockMovement::create([
                    'inventory_item_id' => $item->id,
                    'type' => $movementType,
                    'quantity' => $movementQuantity,
                    'reference_type' => 'Manual Adjustment',
                    'notes' => $validated['notes'] ?? null,
                    'user_id' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('stock.index')
                ->with('success', 'Stock adjusted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to adjust stock: ' . $e->getMessage());
        }
    }

    /**
     * Display stock movement history
     */
    public function movements(Request $request)
    {
        $query = StockMovement::with(['inventoryItem.category', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter by item if provided
        if ($request->has('item_id') && $request->item_id) {
            $query->where('inventory_item_id', $request->item_id);
        }

        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->paginate(20);
        $items = InventoryItem::orderBy('name')->get();

        return view('inventory.stock.movements', compact('movements', 'items'));
    }

    /**
     * Helper method to reduce stock from existing records
     */
    private function reduceStock(InventoryItem $item, int $quantity)
    {
        $remaining = $quantity;
        
        // Get stock records ordered by expiry date (FIFO)
        $stocks = $item->stocks()
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($stocks as $stock) {
            if ($remaining <= 0) {
                break;
            }

            if ($stock->quantity >= $remaining) {
                $stock->quantity -= $remaining;
                $stock->save();
                $remaining = 0;
            } else {
                $remaining -= $stock->quantity;
                $stock->quantity = 0;
                $stock->save();
            }
        }

        if ($remaining > 0) {
            throw new \Exception('Insufficient stock available. Cannot reduce by ' . $quantity);
        }
    }
}
