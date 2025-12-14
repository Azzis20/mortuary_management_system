@extends('client.layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Service Bookings</h1>
        <p class="page-subtitle">View and track your service booking requests</p>
    </div>
</div>

@if($bookings->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 class="empty-state-title">No Bookings Yet</h3>
            <p class="empty-state-text">You haven't made any service bookings yet. Browse our service packages to get started.</p>
            <a href="{{ route('client.services.index') }}" class="btn btn-primary" style="margin-top: 1.5rem;">
                Browse Service Packages
            </a>
        </div>
    </div>
@else
    @foreach($bookings as $booking)
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 class="card-title">Booking #{{ $booking->id }}</h2>
                        <p style="color: #718096; font-size: 0.875rem; margin-top: 0.25rem;">
                            Requested on {{ $booking->created_at->format('F d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <span class="stat-badge 
                        {{ in_array($booking->status, ['Pending', 'Dispatch', 'InCare', 'Viewing', 'Released', 'Declined']) ? 'badge-progress' : ($booking->status === 'Confirmed' ? 'badge-success' : 'badge-danger') }}" 
                        style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <div class="case-info">
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">
                        Service Details
                    </h3>
                    
                    <div class="info-item">
                        <span class="info-label">Service Package:</span>
                        <span class="info-value">{{ $booking->package->package_name ?? 'N/A' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Deceased Person:</span>
                        <span class="info-value">{{ $booking->deceased->name ?? 'N/A' }}</span>
                    </div>
                </div>

                @if($booking->bodyRetrieval)
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">
                        Retrieval Details
                    </h3>
                    
                    <div class="info-item">
                        <span class="info-label">Location:</span>
                        <span class="info-value">{{ $booking->bodyRetrieval->location }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $booking->bodyRetrieval->address }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Preferred Date:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->bodyRetrieval->retrieval_schedule)->format('F d, Y') }}</span>
                    </div>
                </div>
                @endif

                @if($booking->bill)
                <div style="padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">
                        Billing Information
                    </h3>
                    
                    <div class="info-item">
                        <span class="info-label">Amount:</span>
                        <span class="info-value" style="font-size: 1.25rem; font-weight: 600; color: #1a202c;">
                            ₱{{ number_format($booking->bill->balance_amount, 2) }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Payment Status:</span>
                        <span class="info-value">
                            <span class="stat-badge {{ $booking->bill->payment_status === 'fully paid' ? 'badge-paid' : 'badge-unpaid' }}">
                                {{$booking->bill->payment_status }}
                            </span>
                        </span>
                    </div>

                    @if($booking->bill->due_date)
                    <div class="info-item">
                        <span class="info-label">Due Date:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->bill->due_date)->format('F d, Y') }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    @endforeach
@endif
@endsection