@extends('admin.layouts.app')

@section('title', 'book')

@section('page-title', 'Book management')

@section('content')
    <!-- <div class="card">
        <h3>Booking Management</h3>
        <p>Manage bookings</p>
    </div> -->

    <!-- Status Filter Buttons -->
    <div class="card">
        <div class="button-category">
            <a href="{{ route('admin.booking.index') }}" class="btn all-btn {{ $status == 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('admin.booking.pending') }}" class="btn pending-btn {{ $status == 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('admin.booking.activeCase') }}" class="btn activeCase-btn {{ $status == 'activeCase' ? 'active' : '' }}">In Progress</a>
            <a href="{{ route('admin.booking.completed') }}" class="btn completed-btn {{ $status == 'completed' ? 'active' : '' }}">Completed</a>
            <a href="{{ route('admin.booking.declined') }}" class="btn declined-btn {{ $status == 'declined' ? 'active' : '' }}">Declined</a>
        </div>
    </div>


    <!-- Search Form -->
    <div class="card">
        <form action="{{ route('admin.booking.search') }}" method="GET" class="search-form">
            <div class="search-container">
                <input
                    type="text"

                    name="search" 
                    class="search-input" 
                    placeholder="Search for the product..." 
                    value="{{ request('search') }}" >
                <button type="submit" class="btn search-btn">
                    <i class="fa fa-search"> </i> Search 
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Deceased Name</th>
                    <th>Next Of Kin</th>
                    <th>Date Of Admission</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>
                @if ($bookings->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            @if(request('search'))
                                No results found for "{{ request('search') }}"
                            @else
                                No Result
                            @endif
                        </td>
                    </tr>
                @else
                    @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id ?? 'N/A' }}</td>
                        <td>{{ $booking->deceased->name ?? 'N/A' }}</td>
                        <td>{{ $booking->deceased->nextOfKins->name ?? 'N/A' }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                                {{ $booking->status }}
                            </span>
                           
                        </td>
                        <td>
                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm btn-primary" title="View Details"> 
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
        <div>
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    </div>

@endsection

<style>
    




</style>