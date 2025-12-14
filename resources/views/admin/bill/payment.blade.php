@extends('admin.layouts.app')

@section('title', 'Make Payment')

@section('page-title', 'Make Payment')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Bill Information -->
<div class="card">
    <h3>Bill Information</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Bill ID:</strong> {{ $bill->id }}
        </div>
        <div class="info-item">
            <strong>Booking ID:</strong> {{ $bill->book_service_id }}
        </div>
        <div class="info-item">
            <strong>Client Name:</strong> {{ $bill->bookService->client->name }}
        </div>
        <div class="info-item">
            <strong>Deceased Name:</strong> {{ $bill->bookService->deceased->name ?? 'N/A' }}
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
    </div>
</div>

<!-- Payment History -->
@if($bill->payment->count() > 0)
<div class="card">
    <h3>Payment History</h3>
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
        </tbody>
    </table>
</div>
@endif

<!-- Payment Form -->
@if($bill->balance_amount > 0)
<div class="card">
    <h3>Process New Payment</h3>
    <form method="POST" action="{{ route('admin.bill.process-payment', $bill->id) }}">
        @csrf
        
        <div class="form-group">
            <label for="amount">Payment Amount *</label>
            <input 
                type="number" 
                id="amount" 
                name="amount" 
                step="0.01" 
                min="0.01" 
                max="{{ $bill->balance_amount }}" 
                value="{{ old('amount', $bill->balance_amount) }}" 
                required
            >
            <small>Maximum: ₱{{ number_format($bill->balance_amount, 2) }}</small>
            @error('amount')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="payment_date">Payment Date *</label>
            <input 
                type="date" 
                id="payment_date" 
                name="payment_date" 
                value="{{ old('payment_date', date('Y-m-d')) }}" 
                max="{{ date('Y-m-d') }}"
                required
            >
            @error('payment_date')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Process Payment</button>
            <a href="{{ route('admin.bill.show', $bill->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@else
<div class="card">
    <div class="alert alert-success">
        This bill has been fully paid. No payment needed.
    </div>
    <a href="{{ route('admin.bill.show', $bill->id) }}" class="btn btn-primary">Back to Bill Details</a>
</div>
@endif

@endsection