<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deceased;


class AdminDeceasedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $deceases = Deceased::all();
        $deceases = Deceased::latest()
                      ->paginate(5);

         

        return view('admin.decease.deceased-index', compact('deceases'));

    }

 

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function search(Request $request){

        $search = $request->input('search');

                $deceases = Deceased::query()
                ->when($search, function ($query) use ($search) {
                    $query->where('user_id', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('cause_of_death', 'LIKE', "%{$search}%");
                   
            })
            ->paginate(5);
        return view('admin.decease.deceased-index', compact('deceases'))->with('search');
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $deceased = Deceased::findOrFail($id);
        return view('admin.decease.deceased-show', compact('deceased'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
