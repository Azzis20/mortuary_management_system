@extends('client.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Welcome back, {{$user->name}}</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <a href="{{ route('client.decease.index') }}" class="card-link">
            <div class="stat-label">Active Cases</div>
            <div class="stat-value">{{$bookcount}}</div>
            <div class="stat-description">Current active cases</div>
        </a>
    </div>


    <div class="stat-card">
        <a href="{{ route('client.billing.index') }}" class="card-link">
            <div class="stat-label">Total Bill</div>
            <div class="stat-value">₱{{ number_format($totalbill, 2) }}</div>
            <div class="stat-description">Balance</div>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-label">Booked completed</div>
        <div class="stat-value">{{$bookcompleted}}</div>
        <div class="stat-description">Completed Bookings</div>
    </div>
</div>

<!-- Current Book -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Current Book</h2>
    </div>
    
    @if($booking)
    <a href="{{ route('client.decease.show', $booking->deceased->id) }}" class="card-link"> 
    <div class="case-info">
        <div class="info-item">
            <span class="info-label">Book ID:</span>
            <span class="info-value">{{$booking->id}}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Deceased:</span>
            <span class="info-value">{{ $booking->deceased->name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Registered:</span>
            <span class="info-value">{{ $booking->created_at->format('F d, Y h:i A') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Services:</span>
            <span class="info-value">{{$booking->package->package_name}} Service Package</span>
        </div>
        <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value"><span class="stat-badge badge-progress">{{$booking->status}}</span></span>
        </div>
        <div class="info-item">
            <span class="info-label">Payment Status:</span>
            <span class="info-value"><span class="stat-badge badge-unpaid">Balance Due: ₱{{number_format($booking->bill->balance_amount) ?? 0}}</span></span>
        </div>
    </div>
    </a>
    @else
    <p style="padding: 1rem; color: #718096;">No current bookings available.</p>
    @endif

    
</div>
@endsection