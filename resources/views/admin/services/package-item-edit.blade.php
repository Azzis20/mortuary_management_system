@extends('admin.layouts.app')

@section('title', 'Edit Package Item')

@section('page-title', 'Edit Service Item')

@section('content')
    <div class="page-header">
        <h1>Edit Service Item</h1>
        <p>Modify item in {{ $packageItem->package->package_name }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Service Item Details</h3>
        </div>

        <form action="{{ route('admin.package.update', $packageItem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                
                {{-- Service Name --}}
                <div class="form-group">
                    <label for="service_name" class="form-label">Service Name</label>
                    <input 
                        type="text" 
                        name="service_name" 
                        id="service_name" 
                        class="form-input" 
                        value="{{ old('service_name', $packageItem->service_name) }}" 
                        required
                    >
                    @error('service_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-input" 
                        rows="4"
                        style="font-family: Arial, sans-serif; font-size: 16px; color: #333;"
                    >{{ old('description', $packageItem->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Package Info (Read-only) --}}
                <div class="form-group">
                    <label class="form-label">Package</label>
                    <input 
                        type="text" 
                        class="form-input" 
                        value="{{ $packageItem->package->package_name }}" 
                        disabled
                        style="background-color: #f5f5f5;"
                    >
                    <small style="color: #666;">This item belongs to the package above</small>
                </div>

            </div>

            <div class="card-footer form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                
                <a href="{{ route('admin.services.inclusion', $packageItem->package_id) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Delete Section --}}
    <div class="card" style="margin-top: 24px;">
        <div class="card-body">
            <h4 style="padding-bottom: 16px; color: red;">Delete Service Item</h4>

            <p style="padding-bottom: 16px; font-weight: bold;">
                Warning: This action is permanent and cannot be undone. 
                This will remove the item from {{ $packageItem->package->package_name }}.
            </p>
            
            <form action="{{ route('admin.package.destroy', $packageItem->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this service item?');">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Service Item
                </button>
            </form>
        </div>
    </div>
@endsection