@extends('admin.layouts.app')

@section('title', 'Bill Details')

@section('page-title', 'Bill Details')

@section('content')

@php
    $success = session()->pull('success');
@endphp
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Bill Summary -->
<div class="card">
    <h3>Bill Summary</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Bill ID:</strong> {{ $bill->id }}
        </div>
        <div class="info-item">
            <strong>Booking ID:</strong> {{ $bill->book_service_id }}
        </div>
        <div class="info-item">
            <strong>Total Amount:</strong> ₱{{ number_format($bill->total_amount, 2) }}
        </div>
        <div class="info-item">
            <strong>Paid Amount:</strong> ₱{{ number_format($bill->paid_amount, 2) }}
        </div>
        <div class="info-item">
            <strong>Balance Amount:</strong> ₱{{ number_format($bill->balance_amount, 2) }}
        </div>
        <div class="info-item">
            <strong>Payment Status:</strong> 
            <span class="badge badge-{{ $bill->payment_status == 'paid' ? 'success' : ($bill->payment_status == 'partial' ? 'warning' : 'danger') }}">
                {{ ucfirst($bill->payment_status) }}
            </span>
        </div>
        <div class="info-item">
            <strong>Created At:</strong> {{ $bill->created_at->format('M d, Y h:i A') }}
        </div>
        <div class="info-item">
            <strong>Last Updated:</strong> {{ $bill->updated_at->format('M d, Y h:i A') }}
        </div>
    </div>
    
    <div class="actions-row">
        @if($bill->balance_amount > 0)
        <a href="{{ route('admin.bill.payment-form', $bill->id) }}" class="btn btn-success">Make Payment</a>
        @endif
        <a href="{{ route('admin.bill') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<!-- Client Information -->
<div class="card">
    <h3>Client Information</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Name:</strong> {{ $bill->bookService->client->name }}
        </div>
        <div class="info-item">
            <strong>Email:</strong> {{ $bill->bookService->client->email }}
        </div>
        @if($bill->bookService->client->profile)
        <div class="info-item">
            <strong>Phone:</strong> {{ $bill->bookService->client->profile->phone ?? 'N/A' }}
        </div>
        <div class="info-item">
            <strong>Address:</strong> {{ $bill->bookService->client->profile->address ?? 'N/A' }}
        </div>
        @endif
    </div>
</div>

<!-- Deceased Information -->
<div class="card">
    <h3>Deceased Information</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Name:</strong> {{ $bill->bookService->deceased->name ?? 'N/A' }}
        </div>
        <div class="info-item">
            <strong>Date of Death:</strong> {{ $bill->bookService->deceased->date_of_death ?? 'N/A' }}
        </div>
        <div class="info-item">
            <strong>Age:</strong> {{ $bill->bookService->deceased->age ?? 'N/A' }}
        </div>
    </div>
</div>

<!-- Package Information -->
<div class="card">
    <h3>Package Information</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Package:</strong> {{ $bill->bookService->package->name ?? 'N/A' }}
        </div>
        <div class="info-item">
            <strong>Package Price:</strong> ₱{{ number_format($bill->bookService->package->price ?? 0, 2) }}
        </div>
        <div class="info-item">
            <strong>Description:</strong> {{ $bill->bookService->package->description ?? 'N/A' }}
        </div>
    </div>
</div>

<!-- Booking Items (Additional Services) -->
@if($bill->bookService->booking_items->count() > 0)
<div class="card">
    <h3>Additional Services/Items</h3>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->bookService->booking_items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₱{{ number_format($item->unit_price, 2) }}</td>
                <td>₱{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Payment History -->
<div class="card">
    <h3>Payment History</h3>
    @if($bill->payment->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Processed By</th>
                <th>Recorded At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->payment as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>₱{{ number_format($payment->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                <td>{{ $payment->processed_by->name ?? 'N/A' }}</td>
                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Total Paid:</strong></td>
                <td><strong>₱{{ number_format($bill->paid_amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
    @else
    <p>No payments recorded yet.</p>
    @endif
</div>

@endsection