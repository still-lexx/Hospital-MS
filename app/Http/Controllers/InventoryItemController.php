<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of inventory items
     */
    public function index()
    {
        $items = InventoryItem::with(['category', 'stocks'])
            ->withSum('stocks', 'quantity')
            ->orderBy('name')
            ->paginate(15);

        return view('inventory.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new inventory item
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('inventory.items.create', compact('categories'));
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:inventory_items,sku',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        InventoryItem::create($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Inventory item created successfully.');
    }

    /**
     * Display the specified inventory item
     */
    public function show(InventoryItem $item)
    {
        $item->load(['category', 'stocks', 'stockMovements.user']);
        $totalQuantity = $item->stocks()->sum('quantity');
        $recentMovements = $item->stockMovements()->latest()->take(10)->get();

        return view('inventory.items.show', compact('item', 'totalQuantity', 'recentMovements'));
    }

    /**
     * Show the form for editing the specified inventory item
     */
    public function edit(InventoryItem $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('inventory.items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified inventory item
     */
    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:inventory_items,sku,' . $item->id,
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $item->update($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified inventory item
     */
    public function destroy(InventoryItem $item)
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Inventory item deleted successfully.');
    }
}
