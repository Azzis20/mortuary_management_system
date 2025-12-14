@extends('admin.layouts.app')

@section('title', 'Client Bookings')

@section('page-title', 'Client Bookings')

@section('content')

    {{-- Header Section --}}
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <h1 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0;">Client Bookings</h1>
            <a href="{{ route('admin.client') }}" class="btn-minimal">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Profile Overview (Compact) --}}
    <div class="card">
        <div style="display: flex; align-items: center; gap: 24px;">
            {{-- Profile Picture --}}
            <div style="flex-shrink: 0;">
                @if($client->profile && $client->profile->picture)
                     <div class="image-container">
                            <img 
                                src="{{ asset($client->profile->picture) }}" 
                                alt="Document for {{ $client->name }}"
                                class="document-image"
                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;"
                            />
                    </div>
                @else
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 600;">
                        {{ strtoupper(substr($client->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Basic Info --}}
            <div style="flex-grow: 1;">
                <h2 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 600; color: #1a1a1a;">{{ $client->name }}</h2>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">{{ $client->email }}</p>
            </div>

            {{-- View Profile Button --}}
            <div>
                <a href="{{ route('admin.client.show', $client->id) }}" class="btn-minimal">
                    <i class="fas fa-user"></i> View Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Bookings Section --}}
    <div class="card" style="margin-top: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1a1a1a;">Booking History</h3>
            <span style="background: #f3f4f6; padding: 4px 12px; border-radius: 9999px; font-size: 14px; color: #6b7280;">
                {{ $client->bookServices->count() }} Total Bookings
            </span>
        </div>

        @if($client->bookServices && $client->bookServices->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">ID</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">Package</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">Deceased</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">Status</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">Booking Date</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; font-size: 14px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->bookServices as $booking)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px; font-size: 14px; font-weight: 600; color: #3b82f6;">
                                    #{{ $booking->id }}
                                </td>
                                <td style="padding: 12px; font-size: 14px;">
                                    {{ $booking->package->name ?? 'N/A' }}
                                </td>
                                <td style="padding: 12px; font-size: 14px;">
                                    {{ $booking->deceased->name ?? 'N/A' }}
                                </td>
                                <td style="padding: 12px;">
                                    @php
                                        $statusColors = [
                                            'Pending' => 'background: #fef3c7; color: #92400e;',
                                            'Confirmed' => 'background: #dbeafe; color: #1e40af;',
                                            'In Progress' => 'background: #e0e7ff; color: #3730a3;',
                                            'Declined' => 'background: #fee2e2; color: #991b1b;',
                                            'Released' => 'background: #d1fae5; color: #065f46;',
                                        ];
                                        $style = $statusColors[$booking->status] ?? 'background: #f3f4f6; color: #374151;';
                                    @endphp
                                    <span style="padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 500; {{ $style }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td style="padding: 12px; font-size: 14px; color: #6b7280;">
                                    {{ $booking->created_at->format('M d, Y') }}
                                    <div style="font-size: 12px; color: #9ca3af;">
                                        {{ $booking->created_at->format('h:i A') }}
                                    </div>
                                </td>
                                
                                <td style="padding: 12px;">
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}" 
                                           class="btn-minimal btn-primary" 
                                           style="font-size: 14px;"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 48px 24px; color: #9ca3af;">
                <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500; color: #6b7280;">No bookings found</p>
                <p style="margin: 0; font-size: 14px;">This client hasn't made any bookings yet.</p>
            </div>
        @endif
    </div>

    <style>
        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        }

        .btn-minimal:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .btn-minimal.btn-primary {
            background: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .btn-minimal.btn-primary:hover {
            background: #2563eb;
            border-color: #2563eb;
        }

        @media (max-width: 768px) {
            table {
                font-size: 13px;
            }
            
            th, td {
                padding: 8px !important;
            }
        }
    </style>

@endsection