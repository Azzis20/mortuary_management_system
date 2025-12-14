@extends('client.layouts.app')

@section('title', 'Billing')

@section('content')
<div class="page-header">
    <h1 class="page-title">Billing Summary</h1>
    <p class="page-subtitle">View your Billing details</p>
</div>

<div class="card">
    <h2 class="card-title" style="padding-bottom: 1rem;">Billing Status</h2>

    <div class="table-container">
        <table class="table">
            <tbody>
                <tr>
                    <td style="padding: 0.75rem 0; border-top: 2px solid #e2e8f0; font-weight: bold;">Total Bill Amount</td>
                    <td style="text-align: right; padding: 0.75rem 0; border-top: 2px solid #e2e8f0; font-weight: bold;">₱{{ number_format($totalSum, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0;">Amount Paid</td>
                    <td style="text-align: right; color: #10b981; padding: 0.75rem 0;">₱{{ number_format($paidSum, 2) }}</td>
                </tr>
                <tr >
                    <td style="padding: 0.75rem 0; font-weight: bold;">Balance</td>
                    <td style="text-align: right; padding: 0.75rem 0;"><strong >₱{{ number_format($balanceSum, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    

    <div class="form-actions">
        <button class="btn btn-secondary" onclick="window.print()">Print Invoice</button>
    </div>


</div>

<!-- Transaction History -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Transaction History</h2>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Booking ID</th>
                    <th>Payment Date and Time</th>
                    <th style="text-align: right;">Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($payments->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            @if(request('search'))
                                No results found for "{{ request('search') }}"
                            @else
                                No Result
                            @endif
                        </td>
                    </tr>
                @else
                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id ?? 'N/A' }}</td>
                        <td>{{ $payment->bill->bookService->id ?? 'N/A'}}</td>
                        <td>{{ $payment->payment_date?->format('Y-m-d H:i:s') ?? 'N/A' }}</td>
                        <td style="text-align: right;">₱{{ number_format($payment->amount, 2 ?? 'N/A') }}</td> 
                        <td>
                            @if($payment->bill->payment_status == 'fully paid')
                                <span class="stat-badge badge-paid">Paid</span>
                            @elseif($payment->bill->payment_status == 'partial')
                                <span class="stat-badge badge-pending">Partial</span>
                            @else
                                <span class="stat-badge badge-unpaid">Unpaid</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div>
            {{ $payments->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div class="alert" style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-top: 1.5rem; border-radius: 0.375rem;">
        <p style="margin: 0; color: #1e40af;">
            <strong>Payment Instructions:</strong> To settle your outstanding balance, please proceed to our office during business hours.
        </p>
</div>



@endsection
