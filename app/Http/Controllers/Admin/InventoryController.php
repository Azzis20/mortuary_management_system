<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::orderBy('id', 'asc')->paginate(5);
        return view('admin.inventory.inventory-index', compact('inventories'))->with('status', 'all');
    }

     public function edit(string $id)
    {
         $inventory = Inventory::findOrFail($id);
        
        return view('admin.inventory.inventory-edit', compact('inventory'));
        


    }
    public function stockShortage()
    {
       $inventories = Inventory::whereColumn('stock_quantity', '<=', 'min_threshold')
            ->orderBy('stock_quantity', 'asc')
            ->paginate(5);

        return view('admin.inventory.inventory-index', compact('inventories'))->with('status', 'shortage');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.inventory.inventory-create');
}

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'item_name' => 'required|string|max:255|unique:inventories,item_name',
            'category' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'min_threshold' => 'required|integer|min:0',
        ], [
            'item_name.required' => 'Item name is required.',
            'item_name.unique' => 'This item name already exists in inventory.',
            'category.required' => 'Please select a category.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
            'min_threshold.required' => 'Minimum threshold is required.',
            'min_threshold.min' => 'Minimum threshold cannot be negative.',
        ]);

        // Create the new inventory item
        $inventory = Inventory::create($validated);

        // Redirect to the inventory list with success message
        return redirect()
            ->route('admin.inventory')
            ->with('success', 'Product "' . $inventory->item_name . '" has been created successfully!');
    }
    /**
     * Store a newly created resource in storage.
     */
public function update(Request $request, string $id)
{
    // Validate the incoming data
    $validated = $request->validate([
        'item_name' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'stock_quantity' => 'required|integer|min:0',
        'min_threshold' => 'required|integer|min:0',
    ], [
        'item_name.required' => 'Item name is required.',
        'category.required' => 'Please select a category.',
        'stock_quantity.required' => 'Stock quantity is required.',
        'stock_quantity.min' => 'Stock quantity cannot be negative.',
        'min_threshold.required' => 'Minimum threshold is required.',
        'min_threshold.min' => 'Minimum threshold cannot be negative.',
    ]);

    // Find the inventory item
    $inventory = Inventory::findOrFail($id);

    // Update the inventory
    $inventory->update($validated);

    // Redirect back with success message
    return redirect()
        ->route('admin.inventory', $inventory->id)
        ->with('success', 'Inventory updated successfully!');
}




// Optional: Add a method to quickly add stock
public function addStock(Request $request, string $id)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $inventory = Inventory::findOrFail($id);
    $inventory->stock_quantity += $validated['quantity'];
    $inventory->save();

    return redirect()
        ->route('admin.inventory.edit', $inventory->id)
        ->with('success', "Added {$validated['quantity']} units to stock!");
}

// Optional: Add a method to remove stock
public function removeStock(Request $request, string $id)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $inventory = Inventory::findOrFail($id);
    
    if ($inventory->stock_quantity < $validated['quantity']) {
        return redirect()
            ->back()
            ->with('error', 'Cannot remove more items than currently in stock!');
    }

    $inventory->stock_quantity -= $validated['quantity'];
    $inventory->save();

    return redirect()
        ->route('admin.inventory.edit', $inventory->id)
        ->with('success', "Removed {$validated['quantity']} units from stock!");
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $inventories = Inventory::query()
            ->when($search, function ($query) use ($search) {
                $query->where('item_name', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%");
                    
            })
            ->paginate(5);
        

        return view('admin.inventory.inventory-index', compact('inventories'))->with('status', 'search');
    }
}
