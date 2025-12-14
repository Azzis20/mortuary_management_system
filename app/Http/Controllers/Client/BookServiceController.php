<?php
namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\Deceased;
use App\Models\BodyRetrieval;
use App\Models\Bill;
use App\Models\BookService;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookServiceController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $packages = Package::all();
        $packages = Package::with('package_item')->paginate(5);

        return view('client.services.service-index', compact('packages'));
    }

    public function create($packageId)
    {
        $package = Package::findOrFail($packageId);
        
        // Get deceased records that DON'T have active bookings
        $deceasedRecords = Deceased::where('user_id', Auth::id())
            ->whereDoesntHave('bookServices', function ($query) {
                $query->whereIn('status', ['Pending', 'Confirmed', 'In Progress']);
            })
            ->get();
        
        // Check if user has available deceased records
        if ($deceasedRecords->isEmpty()) {
            return redirect()->route('client.decease.index')
                ->with('error', 'All your deceased records already have active bookings, or you need to add a deceased record first.');
        }
        
        return view('client.services.service-create', compact('package', 'deceasedRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'deceased_id' => 'required|exists:deceaseds,id',
            'address' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
        ]);

        $deceased = Deceased::where('id', $validated['deceased_id'])
        ->where('user_id', Auth::id()) // Changed from client_id
        ->firstOrFail();



        try {
            DB::beginTransaction();

          
            $package = Package::findOrFail($validated['package_id']);

          
            $bookService = BookService::create([
                'client_id' => Auth::id(),
                'deceased_id' => $validated['deceased_id'],
                'package_id' => $validated['package_id'],
                'status' => 'Pending',
            ]);


            // Create Body Retrieval Record with booking_id FK
            BodyRetrieval::create([
                'book_service_id' => $bookService->id, // CHANGED: now references BookService
                'location' => $validated['location'],
                'address' => $validated['address'],
                'retrieval_schedule' => $validated['preferred_date'],
            ]);


            // Generate Bill automatically
            Bill::create([
                'book_service_id' => $bookService->id,
                'total_amount' => $package->price,
                'paid_amount' => 0,
                'balance_amount' => $package->price,
                'status' => 'unpaid',
                'due_date' => now()->addDays(30),
            ]);

            
          
   

            DB::commit();

            return redirect()->route('client.services.booking')
                ->with('success', 'Service booking request submitted successfully! Your request is pending admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit booking request: ' . $e->getMessage());
        }   
    }

    public function myBookings()
    {
        $bookings = BookService::where('client_id', Auth::id())
            ->with(['deceased', 'package', 'bodyRetrieval', 'bill'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('client.services.service-booking', compact('bookings'));
    }


    public function viewing(string $id){

        
        

        return view('client.service-viewing', compact('bookings'));
    }


    public function show(BookService $bookService)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookService $bookService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookService $bookService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookService $bookService)
    {

    }
}