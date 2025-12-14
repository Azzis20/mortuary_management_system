@extends('admin.layouts.app')

@section('title', 'Add Package Item')

@section('page-title', 'Add Item to Package: ' . $package->package_name)

@section('content')
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Package Item Details</h3>
        </div>

        <form action="{{ route('admin.package.store') }}" method="POST">
            @csrf
            
            {{-- Hidden field to associate with the package --}}
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <div class="card-body">
                
                {{-- Service Name --}}
                <div class="form-group">
                    <label for="service_name" class="form-label">Service Name</label>
                    <input 
                        type="text" 
                        name="service_name" 
                        id="service_name" 
                        class="form-input" 
                        value="{{ old('service_name') }}" 
                        required
                    >
                    @error('service_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description (Optional) --}}
                <div class="form-group">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-input" 
                        rows="3"
                        style="font-family: Arial, sans-serif; font-size: 16px; color: #333;"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Add more fields as needed for your package items --}}

            </div>

            <div class="card-footer form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Item
                </button>
                
                <a href="{{ route('admin.services.inclusion', $package->id) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection