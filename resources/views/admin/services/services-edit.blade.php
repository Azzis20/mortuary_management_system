@extends('admin.layouts.app')

@section('title', 'Edit Service Package')

@section('page-title', 'Edit Package: ' . $package->package_name)

@section('content')

    <!-- <div class="card">
        <div class="card-header">
            <h3 class="card-title"> Add Feature to Package </h3>
            <a href="{{ route('admin.package.create', $package->id) }}" class="btn btn-primary">
                Add Inclusion
            </a>
        </div>
    </div> -->
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Package Details</h3>
            <a href="{{ route('admin.services.inclusion',$package->id) }}" class="btn btn-primary"> Inclusions </a>
        </div>

        <form action="{{ route('admin.services.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                
                {{-- Package Name --}}
                <div class="form-group">
                    <label for="package_name" class="form-label">Package Name</label>
                    <input 
                        type="text" 
                        name="package_name" 
                        id="package_name" 
                        class="form-input" 
                        value="{{ old('package_name', $package->package_name) }}" 
                        required
                    >
                    @error('package_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-input" 
                        rows="4" 
                        required
                        style="font-family: Arial, sans-serif; font-size: 16px; color: #333;"
                    >{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="form-group">
                    <label for="price" class="form-label">Price (₱)</label>
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        class="form-input" 
                        value="{{ old('price', $package->price) }}" 
                        min="0" 
                        step="1"
                        required
                    >
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="card-footer form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
            
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 style="padding-bottom: 16px; color: red;">Delete Package</h4>

            <p style="padding-bottom: 16px; font-weight: bold;">
                Warning: This action is permanent and cannot be undone. 
                Deleting this package will remove it from all listings.
            </p>
            
            <form action="{{ route('admin.services.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?');">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Package
                </button>
            </form>
        </div>
    </div>
@endsection