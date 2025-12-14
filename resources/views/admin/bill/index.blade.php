@extends('admin.layouts.app')

@section('title', 'Bill Management')

@section('page-title', 'Bill Management')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Monthly Sales Summary -->
<div class="card">
    <h3>Monthly Sales Summary</h3>
    <div class="monthly-summary-grid">
        <div class="month-card">
            <h4>{{ $currentMonthStats['month_name'] }}</h4>
            <div class="sales-amount">₱{{ number_format($currentMonthStats['total_sales'], 2) }}</div>
            <div class="sales-label">Total Sales</div>
        </div>
        <div class="month-card">
            <h4>{{ $lastMonthStats['month_name'] }}</h4>
            <div class="sales-amount">₱{{ number_format($lastMonthStats['total_sales'], 2) }}</div>
            <div class="sales-label">Total Sales</div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="card">
    <div class="actions-row">
        <a href="{{ route('admin.bill.payment-history') }}" class="btn btn-secondary">View Payment History</a>
    </div>
</div>

<!-- Filters -->
<div class="card">
    <h3>Filter Bills</h3>
    <form method="GET" action="{{ route('admin.bill') }}">
        <div class="form-row">

            <div class="form-group">
            
                <label>Search (Client Name/Booking ID)</label>
                <input type="text" name="search" class="search-input" value="{{ request('search') }}" placeholder="Enter client name or booking ID">
               
            </div>


            
            <div class="form-group">
                <label>Payment Status</label>
                

                
                <select name="payment_status">
                    <option value="">All</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>

               
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
                <a href="{{ route('admin.bill') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<!-- Bills Table -->
<div class="card">
    <h3>All Bills</h3> 
    <table class="table">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Booking ID</th>
                <th>Client Name</th>
            
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Balance</th>
                <th>Payment Status</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
            <tr>
                <td>{{ $bill->id }}</td>
                <td>{{ $bill->book_service_id }}</td>
                <td>{{ $bill->bookService->client->name }}</td>
    
                <td>₱{{ number_format($bill->total_amount, 2) }}</td>
                <td>₱{{ number_format($bill->paid_amount, 2) }}</td>
                <td>₱{{ number_format($bill->balance_amount, 2) }}</td>
                <td>
                    <span class="badge badge-{{ $bill->payment_status == 'Fully paid' ? 'success' : ($bill->payment_status == 'partial' ? 'warning' : 'danger') }}">
                        {{ ucfirst($bill->payment_status) }}
                    </span>
                </td>
                <td>{{ $bill->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.bill.show', $bill->id) }}" class="btn btn-sm btn-info">View</a>
                    
                    @if($bill->balance_amount > 0)
                    <a href="{{ route('admin.bill.payment-form', $bill->id) }}" class="btn btn-sm btn-success">Make Payment</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10">No bills found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="pagination">
        {{ $bills->links() }}
    </div>
</div>



<style>
/* Grid container for stats */

</style>


@endsection