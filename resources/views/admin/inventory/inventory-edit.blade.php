@extends('admin.layouts.app')
@section('title', 'Edit Inventory')

@section('page-title', 'Edit Inventory Item')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Inventory: {{ $inventory->item_name }}</h3>
            <a href="{{ route('admin.inventory') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Inventory
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="item_name">Item Name <span style="color: red;">*</span></label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="item_name" 
                    name="item_name" 
                    value="{{ old('item_name', $inventory->item_name) }}" 
                    required
                    placeholder="Enter item name"
                >
            </div>

            <div class="form-group">
                <label for="category">Category <span style="color: red;">*</span></label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">-- Select Category --</option>

                    <option value="Casket" {{ old('category', $inventory->category) == 'Casket' ? 'selected' : '' }}>Casket</option>
                    <option value="Urn" {{ old('category', $inventory->category) == 'Urn' ? 'selected' : '' }}>Urn</option>
                    <option value="Flowers" {{ old('category', $inventory->category) == 'Flowers' ? 'selected' : '' }}>Flowers</option>
                    <option value="Chemical" {{ old('category', $inventory->category) == 'Chemical' ? 'selected' : '' }}>Chemical</option>
                    <option value="Clothing" {{ old('category', $inventory->category) == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="Stationery" {{ old('category', $inventory->category) == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                    <option value="Equipment" {{ old('category', $inventory->category) == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                </select>
            </div>


            <div class="form-group">
                <label for="stock_quantity">Stock Quantity <span style="color: red;">*</span></label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="stock_quantity" 
                    name="stock_quantity" 
                    value="{{ old('stock_quantity', $inventory->stock_quantity) }}" 
                    required
                    min="0"
                    placeholder="Enter current stock quantity"
                >
                <small style="color: #666; font-size: 0.8rem;">Current quantity in stock</small>
            </div>

            <div class="form-group">
                <label for="min_threshold">Minimum Threshold <span style="color: red;">*</span></label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="min_threshold" 
                    name="min_threshold" 
                    value="{{ old('min_threshold', $inventory->min_threshold) }}" 
                    required
                    min="0"
                    placeholder="Enter minimum stock alert level"
                >
                <small style="color: #666; font-size: 0.8rem;">Alert when stock falls below this number</small>
            </div>

            <div class="form-group" style="margin-top: 2rem; display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Inventory
                </button>
                <a href="{{ route('admin.inventory') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Stock Status Info Card -->
    <div class="card" style="margin-top: 1.5rem;">
        <h3>Current Stock Status</h3>
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-top: 1rem;">
            <div>
                <p style="margin: 0; color: #666; font-size: 0.875rem;">Current Stock</p>
                <p style="margin: 0; font-size: 1.5rem; font-weight: 600; color: #1a1a1a;">
                    {{ $inventory->stock_quantity }}
                </p>
            </div>
            <div>
                <p style="margin: 0; color: #666; font-size: 0.875rem;">Min Threshold</p>
                <p style="margin: 0; font-size: 1.5rem; font-weight: 600; color: #1a1a1a;">
                    {{ $inventory->min_threshold }}
                </p>
            </div>
            <div>
                <p style="margin: 0; color: #666; font-size: 0.875rem;">Status</p>
                <p style="margin: 0;">
                    @if($inventory->stock_quantity == 0)
                        <span class="status-badge status-out-of-stock">Out of Stock</span>
                    @elseif($inventory->stock_quantity <= $inventory->min_threshold)
                        <span class="status-badge status-low-stock">Low Stock</span>
                    @else
                        <span class="status-badge status-in-stock">In Stock</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection