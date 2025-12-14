@extends('admin.layouts.app')
@section('title', 'Inventory Management')

@section('page-title', 'Inventory Management')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="button-category">
                <a href="{{ route('admin.inventory') }}" class="btn all-btn {{ $status == 'all' ? 'active' : '' }}">All</a>
                <a href="{{ route('admin.inventory.shortage') }}" class="btn shortage-btn {{ $status == 'shortage' ? 'active' : '' }}">In Shortage</a>
            </div>
            
            <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>

    <!-- <div class="card">
      
         <div class="button-category">
            <a href="{{ route('admin.inventory') }}" class="btn all-btn {{ $status == 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('admin.inventory.shortage') }}" class="btn shortage-btn {{ $status == 'shortage' ? 'active' : '' }}">In Shortage</a>
        </div>

    </div> -->
    
    <!-- Search Form -->
    <div class="card">
        <form action="{{ route('admin.inventory.search') }}" method="GET" class="search-form">
            <div class="search-container">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Search by item name or category..." 
                    value="{{ request('search') }}"
                >
                <button type="submit" class="btn search-btn"><i class="fa fa-search"></i> Search</button>
            </div>
        </form>
    </div>





    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Inventory ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                  
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>
                @if ($inventories->isEmpty())
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
                    @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->id ?? 'N/A' }}</td>
                        <td>{{ $inventory->item_name ?? 'N/A' }}</td>
                        <td>{{ $inventory->category ?? 'N/A' }}</td>
                        <td>{{ $inventory->stock_quantity ?? 'N/A'}}</td>
                        
                        <td>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $inventory->stock_status)) }}">
                                {{ $inventory->stock_status ?? 'N/A'}}
                            </span>
                            </td>
                        
                         <!-- class="btn-view view-btn" -->
                        <td>
                            <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="btn manage-stock">  
                                Manage Stock
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
        <div>
            {{ $inventories->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

