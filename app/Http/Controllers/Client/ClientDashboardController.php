<?php

// namespace App\Http\Controllers;

namespace App\Http\Controllers\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $user = Auth::user();

        $statusesToExclude = ['Cancelled', 'Declined','Released'];
        $bookcount = $user->bookServices()->whereNotIn('status', $statusesToExclude)->count();


        
        $bookcompleted = $user->bookServices()->where('status', 'Released')->count();
        
        $totalbill = DB::table('bills')
        ->join('book_services', 'bills.book_service_id', '=', 'book_services.id')
        ->where('book_services.client_id', $user->id)
        ->sum('bills.balance_amount');
        
        $currentdue = DB::table('bills')
        ->join('book_services', 'bills.book_service_id', '=', 'book_services.id')
        ->where([
            ['book_services.client_id', '=', $user->id],
            ['bills.payment_status', '=', 'unpaid']
            ])
            ->sum('bills.balance_amount');




        
        
        $booking = $user->bookServices()
        ->with(['deceased', 'package','bill'])
        ->latest() 
        ->first();

        
        return view('client.dashboard', compact('user', 'bookcount', 'totalbill', 'currentdue', 'booking','bookcompleted',));
        
    
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
    public function show(string $id)
    {
        //
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
