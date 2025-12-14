@extends('client.layouts.app')

@section('title', 'Viewing Schedule Details')

@section('content')

<div>
    <div class="header-actions">
        <div>
            <h1 class="page-title">Viewing Schedule Details</h1>
            <p class="page-subtitle">Booking #{{ $viewing->bookService->id }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            @if($viewing->canEdit())
                <a href="{{ route('client.viewing.edit', $viewing->id) }}" class="btn btn-secondary">
                    Edit Schedule
                </a>
            @endif
            <a href="{{ route('client.viewing.index') }}" class="btn btn-secondary">
                Back to List
            </a>
        </div>
    </div>
</div>



<div class="details-grid">
    <!-- Left Column -->
    <div class="details-column">
        <!-- Viewing Information -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Viewing Information</h2>
            </div>
            
            <div class="case-info">
                <div class="info-item">
                    <span class="info-label">Viewing Date:</span>
                    <span class="info-value">
                        {{ $viewing->formatted_date }}
                        @if($viewing->isToday())
                            <span class="stat-badge badge-warning">Today</span>
                        @elseif($viewing->days_until !== null)
                            <span class="stat-badge badge-progress">In {{ $viewing->days_until }} days</span>
                        @elseif($viewing->isPast())
                            <span class="stat-badge badge-danger">Past</span>
                        @endif
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Viewing Type:</span>
                    <span class="info-value">
                        <span class="stat-badge {{ $viewing->getViewingTypeBadgeClass() }}">
                            {{ $viewing->viewing_type }}
                        </span>
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="stat-badge {{ $viewing->getStatusBadgeClass() }}">
                            {{ $viewing->status }}
                        </span>
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Location:</span>
                    <span class="info-value">{{ $viewing->location ?: 'Not specified' }}</span>
                </div>
                
                @if($viewing->address)
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $viewing->address }}</span>
                    </div>
                @endif
                
                @if($viewing->special_requests)
                    <div class="info-item">
                        <span class="info-label">Special Requests:</span>
                        <span class="info-value">{{ $viewing->special_requests }}</span>
                    </div>
                @endif
            </div>
            
            <div class="info-meta">
                <div class="info-item">
                    <span class="info-label">Created:</span>
                    <span class="info-value">{{ $viewing->created_at->format('F d, Y g:i A') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Last Updated:</span>
                    <span class="info-value">{{ $viewing->updated_at->format('F d, Y g:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($viewing->canCancel() || $viewing->status === 'Scheduled')
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Actions</h2>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @if($viewing->canEdit())
                        <a href="{{ route('client.viewing.edit', $viewing->id) }}" class="btn btn-primary btn-full">
                            Edit Schedule
                        </a>
                    @endif
                    
                    @if($viewing->canCancel())
                        <form action="{{ route('client.viewing.cancel', $viewing->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel this viewing schedule?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-full">
                                Cancel Schedule
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($viewing->status, ['Cancelled', 'Scheduled']))
                        <form action="{{ route('client.viewing.destroy', $viewing->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this viewing schedule? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-full">
                                Delete Schedule
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column -->
    <div class="details-column">
        <!-- Booking Information -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Related Booking</h2>
            </div>
            
            <div class="case-info">
                <div class="info-item">
                    <span class="info-label">Booking ID:</span>
                    <span class="info-value">#{{ $viewing->bookService->id }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Package:</span>
                    <span class="info-value">{{ $viewing->bookService->package->package_name ?? 'N/A' }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Deceased Name:</span>
                    <span class="info-value">{{ $viewing->bookService->deceased->name }}</span>
                </div>
                
                @if($viewing->bookService->package)
                    <div class="info-item">
                        <span class="info-label">Package Price:</span>
                        <span class="info-value">₱{{ number_format($viewing->bookService->package->price, 2) }}</span>
                    </div>
                @endif
                
                <div class="info-item">
                    <span class="info-label">Booking Date:</span>
                    <span class="info-value">{{ $viewing->bookService->created_at->format('F d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Timeline</h2>
            </div>
            
            <div class="viewing-timeline">
                <div class="timeline-item {{ $viewing->status === 'Scheduled' ? 'active' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Scheduled</div>
                        <div class="timeline-date">{{ $viewing->created_at->format('M d, Y g:i A') }}</div>
                    </div>
                </div>
                
                @if($viewing->status === 'In Progress' || $viewing->status === 'Completed')
                    <div class="timeline-item {{ $viewing->status === 'In Progress' ? 'active' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">In Progress</div>
                            <div class="timeline-date">{{ $viewing->viewing_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                @endif
                
                @if($viewing->status === 'Completed')
                    <div class="timeline-item active">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Completed</div>
                            <div class="timeline-date">{{ $viewing->updated_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>
                @endif
                
                @if($viewing->status === 'Cancelled')
                    <div class="timeline-item cancelled">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Cancelled</div>
                            <div class="timeline-date">{{ $viewing->updated_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection