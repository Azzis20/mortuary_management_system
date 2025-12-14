<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $packages = Package::all();
         
         return view('admin.services.services-index', compact('packages'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
              
        return view('admin.services.services-create');    

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        
            'package_name' => 'required|string|max:255',    
            'description'  => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999999.99',
        
        ]);

        Package::create([
            'created_by'      => auth()->id(), // The admin or user who created it
            'package_name' => $request->package_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'is_active'   => true,
        ]);

        return redirect()->route('admin.services.index')
                     ->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $packageId)
    {
        //

         $package = Package::findOrFail($packageId);

        
        return view('admin.services.services-edit', compact('package'));
    
    }

    /**
     * Update the specified resource in storage.
     */

    
 

     public function update(Request $request, Package $package)
    {
        //
        $request->validate([
            'description' => 'nullable|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',


        ]);

        $package->update($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Package updated successfully!');

    }


    public function destroy(Package $package)
{
    try {
        DB::beginTransaction();
        
        
        $package->delete(); // Deletes the package record from the database

        DB::commit();

        // Redirect the user back to the index page with a success message
        return redirect()->route('admin.services.index')
                         ->with('success', 'Service package deleted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();

        // Redirect back with an error if something goes wrong
        return redirect()->back()
                         ->with('error', 'Failed to delete package: ' . $e->getMessage());
    }
}
    public function inclusion(string $id)
    {
        $package = Package::with('package_item')->findOrFail($id);


        return view('admin.services.service-inclusion',compact('package'));
    }
   
}
