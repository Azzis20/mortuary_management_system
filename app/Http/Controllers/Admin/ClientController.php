<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clients = User::where('accountType', 'client') 
                   ->with('profile')
                   ->latest()
                   ->paginate(5);
       

        return view('admin.customer.client-index', compact('clients'));

    }

    public function show(string $id)
    {
        $client = User::with('profile')->findOrFail($id);

        
        return view('admin.customer.client-show', compact('client'));

    }

    public function search(Request $request)
    {
        $search = $request->input('search');


        $clients = User::when($search, function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->paginate(5);

        return view('admin.customer.client-index', compact('clients'))->with('search');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $client = User::with('profile')->findOrFail($id);



        return view('admin.customer.client-edit',compact('client'));

    }
    public function booking(string $id)
{

    
    $client = User::with([
        'profile',
        'bookServices' => function($query) {
            $query->with(['package', 'deceased'])
                  ->latest();
        }
    ])->findOrFail($id);

  
    
    return view('admin.customer.client-booking', compact('client'));
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
