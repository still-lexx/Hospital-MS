<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of purchase orders
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->orderBy('order_date', 'desc')
            ->paginate(15);

        return view('inventory.purchase-orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new purchase order
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $inventoryItems = InventoryItem::where('status', 'active')->orderBy('name')->get();

        // Generate order number
        $lastOrder = PurchaseOrder::latest('id')->first();
        $orderNumber = 'PO-' . date('Ymd') . '-' . str_pad(($lastOrder ? $lastOrder->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        return view('inventory.purchase-orders.create', compact('suppliers', 'inventoryItems', 'orderNumber'));
    }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_number' => 'required|string|unique:purchase_orders,order_number',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create purchase order
            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'order_number' => $validated['order_number'],
                'order_date' => $validated['order_date'],
                'expected_delivery' => $validated['expected_delivery'] ?? null,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'total_amount' => 0,
            ]);

            // Create purchase order items and calculate total
            $totalAmount = 0;
            foreach ($validated['items'] as $itemData) {
                $total = $itemData['quantity'] * $itemData['unit_price'];
                
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'inventory_item_id' => $itemData['inventory_item_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $total,
                ]);

                $totalAmount += $total;
            }

            // Update total amount
            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified purchase order
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'items.inventoryItem']);
        return view('inventory.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified purchase order
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        // Only allow editing if status is pending
        if ($purchaseOrder->status !== 'pending') {
            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot edit a purchase order that is not pending.');
        }

        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $inventoryItems = InventoryItem::where('status', 'active')->orderBy('name')->get();
        $purchaseOrder->load('items.inventoryItem');

        return view('inventory.purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'inventoryItems'));
    }

    /**
     * Update the specified purchase order
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Only allow updating if status is pending
        if ($purchaseOrder->status !== 'pending') {
            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot update a purchase order that is not pending.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Update purchase order
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery' => $validated['expected_delivery'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing items
            $purchaseOrder->items()->delete();

            // Create new items and calculate total
            $totalAmount = 0;
            foreach ($validated['items'] as $itemData) {
                $total = $itemData['quantity'] * $itemData['unit_price'];
                
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'inventory_item_id' => $itemData['inventory_item_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $total,
                ]);

                $totalAmount += $total;
            }

            // Update total amount
            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Only allow deleting if status is pending
        if ($purchaseOrder->status !== 'pending') {
            return redirect()
                ->route('purchase-orders.index')
                ->with('error', 'Cannot delete a purchase order that is not pending.');
        }

        $purchaseOrder->delete();

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Show the form for receiving a purchase order
     */
    public function receive(PurchaseOrder $purchaseOrder)
    {
        // Only allow receiving if status is pending
        if ($purchaseOrder->status !== 'pending') {
            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'This purchase order has already been processed.');
        }

        $purchaseOrder->load(['supplier', 'items.inventoryItem']);
        return view('inventory.purchase-orders.receive', compact('purchaseOrder'));
    }

    /**
     * Process receiving a purchase order
     */
    public function storeReceive(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Only allow receiving if status is pending
        if ($purchaseOrder->status !== 'pending') {
            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'This purchase order has already been processed.');
        }

        $validated = $request->validate([
            'received_date' => 'required|date',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.expiry_date' => 'nullable|date|after:today',
            'items.*.location' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Update purchase order status
            $purchaseOrder->update([
                'status' => 'received',
                'received_date' => $validated['received_date'],
            ]);

            // Process each item
            foreach ($validated['items'] as $itemData) {
                $poItem = PurchaseOrderItem::findOrFail($itemData['id']);
                $receivedQty = $itemData['received_quantity'];

                if ($receivedQty > 0) {
                    // Add to stock
                    Stock::create([
                        'inventory_item_id' => $poItem->inventory_item_id,
                        'quantity' => $receivedQty,
                        'unit_price' => $poItem->unit_price,
                        'batch_number' => $itemData['batch_number'] ?? null,
                        'expiry_date' => $itemData['expiry_date'] ?? null,
                        'location' => $itemData['location'] ?? null,
                    ]);

                    // Record stock movement
                    StockMovement::create([
                        'inventory_item_id' => $poItem->inventory_item_id,
                        'type' => 'in',
                        'quantity' => $receivedQty,
                        'reference_type' => 'PurchaseOrder',
                        'reference_id' => $purchaseOrder->id,
                        'notes' => 'Received from PO: ' . $purchaseOrder->order_number,
                        'user_id' => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order received and stock updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to receive purchase order: ' . $e->getMessage());
        }
    }
}
