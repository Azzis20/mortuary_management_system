@extends('admin.layouts.app')

@section('title', 'Payment History')

@section('page-title', 'Payment History')

@section('content')

<!-- Filters -->
<div class="card">
    <h3>Filter Payments</h3>
    <form method="GET" action="{{ route('admin.bill.payment-history') }}">
        <div class="form-row">
            <div class="form-group">
                <label>Search (Client Name)</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter client name">
            </div>
            
            <div class="form-group">
                <label>Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
            </div>
            
            <div class="form-group">
                <label>Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.bill.payment-history') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>



<!-- Payments Table -->
<div class="card">
    <h3>All Payments</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Bill ID</th>
                <th>Client Name</th>
                <th>Deceased Name</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Processed By</th>
                <th>Recorded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->bill_id }}</td>
                <td>{{ $payment->bill->bookService->client->name }}</td>
                <td>{{ $payment->bill->bookService->deceased->name ?? 'N/A' }}</td>
                <td>₱{{ number_format($payment->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                <td>{{ $payment->processed_by->name ?? 'N/A' }}</td>
                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                <td>
                    <a href="{{ route('admin.bill.show', $payment->bill_id) }}" class="btn btn-sm btn-info">View Bill</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No payments found</td>
            </tr>
            @endforelse
        </tbody>
        @if($payments->count() > 0)
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total on this page:</strong></td>
                <td><strong>₱{{ number_format($payments->sum('amount'), 2) }}</strong></td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
        @endif
    </table>
    
    <div class="pagination">
        {{ $payments->links() }}
    </div>
</div>

<div class="card">
    <a href="{{ route('admin.bill') }}" class="btn btn-secondary">Back to Bills</a>
</div>

@endsection