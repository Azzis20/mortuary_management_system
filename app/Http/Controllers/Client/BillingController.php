<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Bill;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    
      // Step 1: Define the base query scope (the WHERE condition)
        $billQuery = Bill::whereHas('bookService', function ($query) {
            $query->where('client_id', auth()->id());
        });

        $totalSum = $billQuery->sum('total_amount');
        $paidSum = $billQuery->sum('paid_amount');
        $balanceSum = $billQuery->sum('balance_amount');


    
        $payments = Payment::with('bill', 'bill.bookService')
        ->where('client_id', auth()->id()) 
        ->orderBy('created_at', 'desc')
        ->paginate(10);



        return view('client.billing.billing-index',compact('payments','totalSum','paidSum','balanceSum'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function billingSummary()
    {
        return view('client.billing.billing-summary');
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
