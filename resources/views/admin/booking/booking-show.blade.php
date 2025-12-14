@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('page-title', 'Booking Management')

@section('content')

    {{-- Header Section --}}
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <div>
                <h1 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0 0 4px 0;">
                    Booking #{{ $booking->id }}
                </h1>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                    Created on {{ $booking->created_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.client.booking', $booking->client_id) }}" class="btn-minimal">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button class="btn-minimal" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    {{-- Status Banner --}}
    <div class="status-banner status-{{ strtolower($booking->status) }}">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-info-circle" style="font-size: 20px;"></i>
            <div>
                <div style="font-weight: 600; font-size: 16px;">Status: {{ $booking->status }}</div>
                @if($booking->updated_at->ne($booking->created_at))
                    <div style="font-size: 13px; opacity: 0.9;">
                        Last updated: {{ $booking->updated_at->diffForHumans() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 24px;">
        
        {{-- Left Column --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Client Information --}}
            <div class="card">
                <h3 class="card-title">
                    <i class="fas fa-user"></i> Client Information
                </h3>
                <div style="display: flex; align-items: center; gap: 16px;">
                    @if($booking->client->profile && $booking->client->profile->picture)
                        <img 
                            src="{{ asset($booking->client->profile->picture) }}" 
                            alt="{{ $booking->client->name }}" 
                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;"
                        >
                    @else
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 600;">
                            {{ strtoupper(substr($booking->client->name, 0, 1)) }}
                        </div>
                    @endif

                    <!-- ///
                     -->

                    <div style="flex-grow: 1;">
                        <div style="font-weight: 600; font-size: 16px; color: #1a1a1a; margin-bottom: 4px;">
                            {{ $booking->client->name }}
                        </div>
                        <div style="font-size: 14px; color: #6b7280;">
                            <i class="fas fa-envelope" style="width: 16px;"></i> {{ $booking->client->email }}
                        </div>
                        @if($booking->client->profile && $booking->client->profile->contact)
                            <div style="font-size: 14px; color: #6b7280;">
                                <i class="fas fa-phone" style="width: 16px;"></i> {{ $booking->client->profile->contact }}
                            </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('admin.client.show', $booking->client->id) }}" class="btn-minimal btn-sm">
                        View Profile
                    </a>
                </div>
            </div>

            {{-- Deceased Information --}}
            <div class="card">
                <h3 class="card-title">
                    <i class="fas fa-cross"></i> Deceased Information
                </h3>
                @if($booking->deceased)
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-key">Full Name</span>
                            <span class="info-val">{{ $booking->deceased->name }}</span>
                        </div>
                        @if($booking->deceased->date_of_birth)
                            <div class="info-item">
                                <span class="info-key">Date of Birth</span>
                                <span class="info-val">
                                    {{ \Carbon\Carbon::parse($booking->deceased->date_of_birth)->format('F d, Y') }}
                                </span>
                            </div>
                        @endif
                        @if($booking->deceased->date_of_death)
                            <div class="info-item">
                                <span class="info-key">Date of Death</span>
                                <span class="info-val">
                                    {{ \Carbon\Carbon::parse($booking->deceased->date_of_death)->format('F d, Y') }}
                                </span>
                            </div>
                        @endif
                        @if($booking->deceased->age)
                            <div class="info-item">
                                <span class="info-key">Age</span>
                                <span class="info-val">{{ $booking->deceased->age }} years old</span>
                            </div>
                        @endif
                        @if($booking->deceased->gender)
                            <div class="info-item">
                                <span class="info-key">Gender</span>
                                <span class="info-val">{{ $booking->deceased->gender }}</span>
                            </div>
                        @endif
                        @if($booking->deceased->cause_of_death)
                            <div class="info-item">
                                <span class="info-key">Cause of Death</span>
                                <span class="info-val">{{ $booking->deceased->cause_of_death }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <p style="color: #9ca3af; font-style: italic;">No deceased information available</p>
                @endif
            </div>

            {{-- Package Details --}}
            <div class="card">
                <h3 class="card-title">
                    <i class="fas fa-box"></i> Package Details
                </h3>
                @if($booking->package)
                    <div style="background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 16px;">
                        <div style="font-weight: 600; font-size: 18px; color: #1a1a1a; margin-bottom: 8px;">
                            {{ $booking->package->name }}
                        </div>
                        @if($booking->package->description)
                            <div style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                                {{ $booking->package->description }}
                            </div>
                        @endif
                        @if($booking->package->price)
                            <div style="font-size: 24px; font-weight: 700; color: #3b82f6; margin-top: 12px;">
                                ₱{{ number_format($booking->package->price, 2) }}
                            </div>
                        @endif
                    </div>
                    
                    @if($booking->package->inclusions)
                        <div>
                            <div style="font-weight: 600; font-size: 14px; color: #1a1a1a; margin-bottom: 8px;">
                                Package Inclusions:
                            </div>
                            <div style="font-size: 14px; color: #6b7280; line-height: 1.8;">
                                {!! nl2br(e($booking->package->inclusions)) !!}
                            </div>
                        </div>
                    @endif
                @else
                    <p style="color: #9ca3af; font-style: italic;">No package information available</p>
                @endif
            </div>

            {{-- Notes Section --}}
            @if($booking->notes)
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-sticky-note"></i> Administrative Notes
                    </h3>
                    <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 4px;">
                        <p style="margin: 0; color: #78350f; font-size: 14px; line-height: 1.6;">
                            {{ $booking->notes }}
                        </p>
                    </div>
                </div>
            @endif

        </div>

        {{-- Right Column (Sidebar) --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
                    {{-- Quick Actions --}}
            <div class="card">
                <h3 class="card-title">Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 8px;">

                    <!-- Update Status Button -->
                    <button class="btn-action btn-success" onclick="window.location='{{ route('admin.booking.edit', $booking->id) }}'">
                        <i class="fas fa-check-circle"></i> Update Status
                    </button>

                  
                    <form method="POST" action="{{ route('admin.booking.decline', $booking->id) }}" 
                        onsubmit="return confirm('Are you sure you want to decline this booking?')">
                        @csrf
                        @method('PUT')
                        <!-- Submit Button -->
                        <button type="submit" class="btn-action btn-danger" style="margin-top: 8px;">
                            <i class="fas fa-times-circle"></i> Decline Booking
                        </button>

            
                    </form>

                </div>
            </div>


            


            {{-- Booking Timeline --}}
            <div class="card">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i> Timeline
                </h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Booking Created</div>
                            <div class="timeline-date">{{ $booking->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                    
                    @if($booking->updated_at->ne($booking->created_at))
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Last Updated</div>
                                <div class="timeline-date">{{ $booking->updated_at->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($booking->approved_by)
                        <div class="timeline-item">
                            <div class="timeline-dot timeline-dot-success"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Approved</div>
                                <div class="timeline-date">By: {{ $booking->approver->name ?? 'Admin' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Additional Info --}}
            <div class="card">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Additional Information
                </h3>
                <div class="info-list">
                    <div class="info-item-small">
                        <span class="info-key-small">Booking ID</span>
                        <span class="info-val-small">#{{ $booking->id }}</span>
                    </div>
                    @if($booking->status_id)
                        <div class="info-item-small">
                            <span class="info-key-small">Status ID</span>
                            <span class="info-val-small">{{ $booking->status_id }}</span>
                        </div>
                    @endif
                    @if($booking->approved_by)
                        <div class="info-item-small">
                            <span class="info-key-small">Approved By</span>
                            <span class="info-val-small">{{ $booking->approver->name ?? 'N/A' }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <style>
        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-banner {
            padding: 16px 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .status-banner.status-pending {
            background: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }

        .status-banner.status-confirmed {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1e40af;
        }

        .status-banner.status-in.progress {
            background: #e0e7ff;
            border-color: #6366f1;
            color: #3730a3;
        }

        .status-banner.status-declined {
            background: #fee2e2;
            border-color: #ef4444;
            color: #991b1b;
        }

        .status-banner.status-released {
            background: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
        }

        .info-key {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-val {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item-small {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item-small:last-child {
            border-bottom: none;
        }

        .info-key-small {
            font-size: 13px;
            color: #6b7280;
        }

        .info-val-small {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .btn-minimal {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            background: white;
            color: #374151;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-minimal:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .btn-minimal.btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .btn-action {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action.btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-action.btn-primary:hover {
            background: #2563eb;
        }

        .btn-action.btn-success {
            background: #10b981;
            color: white;
        }

        .btn-action.btn-success:hover {
            background: #059669;
        }

        .btn-action.btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-action.btn-danger:hover {
            background: #dc2626;
        }

        .timeline {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .timeline-item {
            display: flex;
            gap: 12px;
            position: relative;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 7px;
            top: 24px;
            width: 2px;
            height: calc(100% + 6px);
            background: #e5e7eb;
        }

        .timeline-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #3b82f6;
            border: 3px solid #dbeafe;
            flex-shrink: 0;
            margin-top: 2px;
            z-index: 1;
        }

        .timeline-dot-success {
            background: #10b981;
            border-color: #d1fae5;
        }

        .timeline-content {
            flex-grow: 1;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .timeline-date {
            font-size: 13px;
            color: #6b7280;
        }

        @media print {
            .btn-minimal, .btn-action {
                display: none !important;
            }
        }

        @media (max-width: 1024px) {
            div[style*="grid-template-columns: 2fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

@endsection