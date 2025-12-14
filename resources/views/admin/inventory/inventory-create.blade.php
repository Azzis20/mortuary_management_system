@extends('admin.layouts.app')
@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add New Inventory Item</h3>
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

        <form action="{{ route('admin.inventory.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="item_name">Item Name <span style="color: red;">*</span></label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="item_name" 
                    name="item_name" 
                    value="{{ old('item_name') }}" 
                    required
                    placeholder="Enter item name"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="category">Category <span style="color: red;">*</span></label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Casket" {{ old('category') == 'Casket' ? 'selected' : '' }}>Casket</option>
                    <option value="Urn" {{ old('category') == 'Urn' ? 'selected' : '' }}>Urn</option>
                    <option value="Flowers" {{ old('category') == 'Flowers' ? 'selected' : '' }}>Flowers</option>
                    <option value="Embalming Supplies" {{ old('category') == 'Embalming Supplies' ? 'selected' : '' }}>Embalming Supplies</option>
                    <option value="Memorial Items" {{ old('category') == 'Memorial Items' ? 'selected' : '' }}>Memorial Items</option>
                    <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Initial Stock Quantity <span style="color: red;">*</span></label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="stock_quantity" 
                    name="stock_quantity" 
                    value="{{ old('stock_quantity', 0) }}" 
                    required
                    min="0"
                    placeholder="Enter initial stock quantity"
                >
                <small style="color: #666; font-size: 0.8rem;">Starting quantity for this item</small>
            </div>

            <div class="form-group">
                <label for="min_threshold">Minimum Threshold <span style="color: red;">*</span></label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="min_threshold" 
                    name="min_threshold" 
                    value="{{ old('min_threshold', 5) }}" 
                    required
                    min="0"
                    placeholder="Enter minimum stock alert level"
                >
                <small style="color: #666; font-size: 0.8rem;">You'll be alerted when stock falls below this number</small>
            </div>

            <div class="form-group" style="margin-top: 2rem; display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Product
                </button>
                <a href="{{ route('admin.inventory') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <!-- <div class="card" style="margin-top: 1.5rem;">
        <h3>Quick Tips</h3>
        <ul style="margin: 0.5rem 0 0; padding-left: 1.5rem; color: #666; font-size: 0.875rem;">
            <li style="margin-bottom: 0.5rem;">Choose a clear, descriptive name for easy identification</li>
            <li style="margin-bottom: 0.5rem;">Set the minimum threshold based on your typical usage rate</li>
            <li style="margin-bottom: 0.5rem;">You'll receive low stock alerts when inventory falls below the threshold</li>
            <li style="margin-bottom: 0.5rem;">You can update stock quantities anytime after creation</li>
        </ul>
    </div> -->
@endsection