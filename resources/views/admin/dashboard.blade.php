
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <!-- <div class="card">
        <h3>Dashboard Overview</h3>
        <p>Welcome to the Mortuary Management System</p>
    </div> -->

    

    <div class="dashboard-content">

        <div class="cards-flex">

            <div class="card">
                <a href="{{ route('admin.booking.activeCase') }}" class="card-link">
                <h3>Active Cases</h3>
                <div class="dashboard-icon-text">
                <h1> <i class="fa-solid fa-book"> {{ $activeCase }} </i>  </h1>
                </div>
                </a>
                
            </div>

            <div class="card">
                <a href="{{ route('admin.booking.pending') }}" class="card-link">
                <h3>Pending Approval</h3>
                <div class="dashboard-icon-text">

                    <h1> <i class="fa-solid fa-book"> {{ $pending }}  </i>  </h1>
                </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('admin.retrieval') }}" class="card-link">
                    <h3>Today's Retrieval</h3>
                    
                    <div class="dashboard-icon-text">
                        <h1> <i class="fa-solid fa-calendar-day"> {{$todayRetrieval }}  </i>  </h1>
                    </div>
                </a>
            </div>


            <div class="card">
                <a href="{{ route('admin.client') }}" class="card-link">
                    <h3> Total Clients </h3>
                
                    <div class="dashboard-icon-text">
                        <h1> <i class="fa-solid fa-user"> {{$totalClients }}</i>   </h1>
                    </div>
                </a>
            </div>

        </div> 
        <!--     -->


        <!-- bill
        -->
        <div class="cards-flex-bottom"> 

            {{-- Sales Card --}}
            <div class="sales-card">
                <a href="{{ route('admin.bill') }}" class="card-link">
                <h4 class="card-title">Monthly Sales</h4>
                <h2 class="sales-amount">₱{{ number_format($currentMonthTotalSales, 2) }}</h2>
                
                <div class="sales-footer">
                    <span class="footer-label">Compared to last month</span>
                    @if($salesComparisonStatus === 'increase')
                        <span class="percent percent-up">+{{ $salesPercentageChange }}%</span>
                    @elseif($salesComparisonStatus === 'decrease')
                        <span class="percent percent-down">{{ $salesPercentageChange }}%</span>
                    @else
                        <span class="percent percent-neutral">0%</span>
                    @endif
                </div>
                </a>
            </div>

            {{-- Stock Card --}}
            <div class="stock-card">
                <h4 class="card-title">Stock Alert</h4>
                
                <div class="stock-list">
                    @forelse ($stocks as $stock)
                        <a href="{{ route('admin.inventory.shortage') }}" class="stock-item">
                            <div class="stock-left">
                                <h5 class="stock-name">{{ $stock->item_name }}</h5>
                                <span class="stock-qty">{{ $stock->stock_quantity }} left</span>
                            </div>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $stock->stock_status)) }}">
                                {{ $stock->stock_status }}
                            </span>
                        </a>
                    @empty
                        <div class="empty-state">
                            <p>No stock items</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>


        
    </div>


@endsection


<style>
    .dashboard-content {
        max-width: 1400px;
        margin: 0 auto;
    }

    .cards-flex {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .cards-flex-bottom {
        display: flex;
        gap: 20px;
    }

    /* ========== UPPER CARDS ========== */
    .card {
        flex: 1;
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(190, 219, 254, 0.5);
    }

    .card h3 {
        margin: 0 0 16px 0;
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .dashboard-icon-text h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        color: #3b82f6;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dashboard-icon-text i {
        font-size: 28px;
    }

    /* ========== SALES CARD (Simple & Clean) ========== */
    .sales-card {
        flex: 1;
        background: white;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .sales-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(190, 219, 254, 0.5);
    }

    .card-title {
        margin: 0 0 16px 0;
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sales-amount {
        margin: 0 0 24px 0;
        font-size: 36px;
        font-weight: 700;
        color: #111827;
    }

    .sales-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .footer-label {
        font-size: 13px;
        color: #6b7280;
    }

    .percent {
        font-weight: 600;
        font-size: 14px;
        padding: 4px 12px;
        border-radius: 6px;
    }

    .percent-up {
        color: #16a34a;
        background: #dcfce7;
    }

    .percent-down {
        color: #dc2626;
        background: #fee2e2;
    }

    .percent-neutral {
        color: #6b7280;
        background: #f3f4f6;
    }




    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
        .cards-flex,
        .cards-flex-bottom {
            flex-direction: column;
        }
    }
</style>