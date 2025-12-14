@extends('client.layouts.app')

@section('title', 'Viewing Schedule')

@section('content')

<div>
    <h1 class="page-title">Viewing Schedule</h1>
    <p class="page-subtitle">Manage viewing schedules for your bookings</p>
</div>




<!-- Bookings with Viewing Schedules -->
@if($withViewings->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Scheduled Viewings</h2>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package</th>
                        <th>Viewing Date</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withViewings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->package->package_name ?? 'N/A' }}</td>
                            <td>
                                {{ $booking->viewing->formatted_date }}
                                @if($booking->viewing->isToday())
                                    <span class="stat-badge badge-warning">Today</span>
                                @elseif($booking->viewing->days_until !== null && $booking->viewing->days_until <= 3)
                                    <span class="stat-badge badge-progress">{{ $booking->viewing->days_until }} days</span>
                                @endif
                            </td>
                            <td>{{ $booking->viewing->location ?: 'Not specified' }}</td>
                            <td>
                                <span class="stat-badge {{ $booking->viewing->getViewingTypeBadgeClass() }}">
                                    {{ $booking->viewing->viewing_type }}
                                </span>
                            </td>
                            <td>
                                <span class="stat-badge {{ $booking->viewing->getStatusBadgeClass() }}">
                                    {{ $booking->viewing->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('client.viewing.show', $booking->viewing->id) }}" class="btn btn-secondary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- Bookings without Viewing Schedules -->
@if($withoutViewings->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Bookings Requiring Viewing Schedule</h2>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package</th>
                        <th>Deceased Name</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withoutViewings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->package->name ?? 'N/A' }}</td>
                            <td>{{ $booking->deceased_name }}</td>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('client.viewing.create', $booking->id) }}" class="btn btn-primary">
                                    Set Schedule
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- Empty State -->
@if($withViewings->count() === 0 && $withoutViewings->count() === 0)
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">📅</div>
            <h3 class="empty-state-title">No Bookings Found</h3>
            <p class="empty-state-text">You don't have any bookings yet. Create a booking first to schedule a viewing.</p>
        </div>
    </div>
@endif

@endsection