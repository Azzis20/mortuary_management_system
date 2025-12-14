<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Viewing;
use App\Models\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ViewingController extends Controller
{
    /**
     * Display a listing of viewings for the authenticated client
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all bookings for this client with their viewings
        $bookings = BookService::where('client_id', $user->id)
            ->with(['viewing', 'package'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Separate bookings with and without viewings
        $withViewings = $bookings->filter(fn($booking) => $booking->viewing !== null);
        $withoutViewings = $bookings->filter(fn($booking) => $booking->viewing === null);
        
        return view('client.viewing.viewing-index', compact('withViewings', 'withoutViewings'));
    }

    /**
     * Show the form for creating a new viewing schedule
     */
    public function create($bookingId)
    {
        $booking = BookService::where('id', $bookingId)
            ->where('client_id', Auth::id())
            ->with('package')
            ->firstOrFail();
        
        // Check if viewing already exists
        if ($booking->viewing) {
            return redirect()->route('client.viewing.index')
                ->with('error', 'A viewing schedule already exists for this booking.');
        }
        
        return view('client.viewing.viewing-create', compact('booking'));
    }

    /**
     * Store a newly created viewing schedule
     */
    public function store(Request $request, $bookingId)
    {
        $booking = BookService::where('id', $bookingId)
            ->where('client_id', Auth::id())
            ->firstOrFail();
        
        // Check if viewing already exists
        if ($booking->viewing) {
            return redirect()->route('client.viewing.index')
                ->with('error', 'A viewing schedule already exists for this booking.');
        }
        
        $validated = $request->validate([
            'viewing_date' => 'required|date|after_or_equal:today',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'viewing_type' => 'required|in:Public,Private,Family Only',
            'special_requests' => 'nullable|string',
        ]);
        
        $viewing = Viewing::create([
            'book_service_id' => $booking->id,
            'viewing_date' => $validated['viewing_date'],
            'location' => $validated['location'],
            'address' => $validated['address'],
            'viewing_type' => $validated['viewing_type'],
            'special_requests' => $validated['special_requests'],
            'status' => 'Scheduled',
        ]);
        
        return redirect()->route('client.viewing.show', $viewing->id)
            ->with('success', 'Viewing schedule created successfully.');
    }

    /**
     * Display the specified viewing schedule
     */
    public function show($id)
    {
        $viewing = Viewing::with(['bookService.package', 'bookService.client'])
            ->whereHas('bookService', function($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);
        
        return view('client.viewing.viewing-show', compact('viewing'));
    }

    /**
     * Show the form for editing the specified viewing schedule
     */
    public function edit($id)
    {
        $viewing = Viewing::with(['bookService.package'])
            ->whereHas('bookService', function($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);
        
        // Only allow editing if status is Scheduled
        if ($viewing->status !== 'Scheduled') {
            return redirect()->route('client.viewing.show', $viewing->id)
                ->with('error', 'Cannot edit viewing schedule with status: ' . $viewing->status);
        }
        
        return view('client.viewing.viewing-edit', compact('viewing'));
    }

    /**
     * Update the specified viewing schedule
     */
    public function update(Request $request, $id)
    {
        $viewing = Viewing::with('bookService')
            ->whereHas('bookService', function($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);
        
        // Only allow editing if status is Scheduled
        if ($viewing->status !== 'Scheduled') {
            return redirect()->route('client.viewing.show', $viewing->id)
                ->with('error', 'Cannot edit viewing schedule with status: ' . $viewing->status);
        }
        
        $validated = $request->validate([
            'viewing_date' => 'required|date|after_or_equal:today',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'viewing_type' => 'required|in:Public,Private,Family Only',
            'special_requests' => 'nullable|string',
        ]);
        
        $viewing->update($validated);
        
        return redirect()->route('client.viewing.show', $viewing->id)
            ->with('success', 'Viewing schedule updated successfully.');
    }

    /**
     * Cancel the viewing schedule
     */
    public function cancel($id)
    {
        $viewing = Viewing::whereHas('bookService', function($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);
        
        if ($viewing->status === 'Cancelled' || $viewing->status === 'Completed') {
            return redirect()->route('client.viewing.show', $viewing->id)
                ->with('error', 'Cannot cancel viewing with status: ' . $viewing->status);
        }
        
        $viewing->update(['status' => 'Cancelled']);
        
        return redirect()->route('client.viewing.index')
            ->with('success', 'Viewing schedule cancelled successfully.');
    }

    /**
     * Remove the specified viewing schedule from storage
     */
    public function destroy($id)
    {
        $viewing = Viewing::whereHas('bookService', function($query) {
                $query->where('client_id', Auth::id());
            })
            ->findOrFail($id);
        
        // Only allow deletion if status is Cancelled or Scheduled
        if (!in_array($viewing->status, ['Cancelled', 'Scheduled'])) {
            return redirect()->route('client.viewing.show', $viewing->id)
                ->with('error', 'Cannot delete viewing with status: ' . $viewing->status);
        }
        
        $viewing->delete();
        
        return redirect()->route('client.viewing.index')
            ->with('success', 'Viewing schedule deleted successfully.');
    }
}