<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageItem;

class PackageItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
// <form action="{{ route('client.services.create', $package->id) }}" method="GET" style="width: 100%;">
    /**
     * Show the form for creating a new resource.
     */
public function create(string $id)
{
    // Fixed: Changed $packageId to $id to match the parameter
    $package = PackageItem::findOrFail($id);
    
    // Pass the package data to the view
    return view('admin.services.package-create', compact('package'));
}

public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'package_id' => 'required|exists:packages,id',
        'service_name' => 'required|string|max:255', // Changed to service_name
        'description' => 'nullable|string',
        // Add other fields as needed
    ]);

    // Create the package item
    PackageItem::create($validated);

    return redirect()
        ->route('admin.services.inclusion', $validated['package_id'])
        ->with('success', 'Package item added successfully!');
}

public function edit(string $id)
{
    $packageItem = PackageItem::with('package')->findOrFail($id);
    return view('admin.services.package-item-edit', compact('packageItem'));
}

public function update(Request $request, string $id)
{
    $packageItem = PackageItem::findOrFail($id);
    
    // Validate the incoming request
    $validated = $request->validate([
        'service_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Update the package item
    $packageItem->update($validated);

    return redirect()
        ->route('admin.services.inclusion', $packageItem->package_id)
        ->with('success', 'Package item updated successfully!');
}

public function destroy(string $id)
{
    $packageItem = PackageItem::findOrFail($id);
    $packageId = $packageItem->package_id;
    
    $packageItem->delete();

    return redirect()
        ->route('admin.services.inclusion', $packageId)
        ->with('success', 'Package item deleted successfully!');
}
}
