<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookService;
use App\Models\BodyRetrieval;

class BookingController extends Controller
{
        public function index()
    {
        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'all');
    }
    // public function selectConfirmed()
    // {
    //     $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
    //         ->where('status', 'Confirmed')
    //         ->paginate(5);

    //     return view('admin.booking.booking-index', compact('bookings'))->with('status', 'confirmed');
    // }
    public function selectActiveCase() //selectActiveCase
    {  
        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->whereIn('status', ['In Progress', 'Confirmed', 'Dispatch', 'InCare', 'Viewing'])
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'activeCase');
    }

    public function selectPending()
    {
        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->where('status', 'Pending')
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'pending');
    }


    public function selectCompleted()
    {
        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->where('status', 'Released')
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'completed');
    }

    public function selectDeclined()
    {
        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->where('status', 'Declined')
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'declined');
    }






    public function search(Request $request)
    {
        $search = $request->input('search');

        $bookings = BookService::with(['deceased', 'deceased.nextOfKins'])
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('deceased', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('deceased.nextOfKins', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->paginate(5);

        return view('admin.booking.booking-index', compact('bookings'))->with('status', 'search');
    }
    
    
        public function edit($id)
    {
        $booking = BookService::with(['deceased', 'deceased.nextOfKins'])->findOrFail($id);
        
        return view('admin.booking.booking-edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = BookService::findOrFail($id);
        
        // Validate the request
        
        $request->validate([
        'status' => 'required|in:Pending,Confirmed,Dispatch,InCare,Viewing,Released,Declined',
        ]);
            
        
        // Update the booking
        $booking->update($request->all());
        
        return redirect()->route('admin.booking.index')->with('success', 'Booking updated successfully!');
    }


    public function show(string $id)
    {
        $booking = BookService::with([
            'client.profile',
            'package',
            'deceased',
            // 'approved_by' // If you have this relationship
        ])->findOrFail($id);
        
        return view('admin.booking.booking-show', compact('booking'));
    }

public function declineBooking($id)
{
    // Find the booking
    $booking = BookService::findOrFail($id);

    // Update the status to Declined
    $booking->update([
        'status' => 'Declined',
    ]);

    return redirect()->route('admin.booking.index')
                     ->with('success', 'Booking has been declined successfully!');
}
}