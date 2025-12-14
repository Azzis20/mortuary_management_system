@extends('admin.layouts.app')

@section('title', 'Service Inclusions')

@section('page-title', 'Service Inclusions for ' . $package->package_name)

@section('content')
    

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-title">Package Overview</h3>
            
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                <div>
                    <strong>Package Name:</strong>
                    <p>{{ $package->package_name }}</p>
                </div>
                <div>
                    <strong>Price:</strong>
                    <p>₱{{ number_format($package->price, 2) }}</p>
                </div>
                <div>
                    <strong>Total Items:</strong>
                    <p>{{ $package->package_item->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Add New Item Button --}}
    <div class="card">

        <div class="card-header">
            <a href="{{ route('admin.package.create', $package->id) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Service Item
            </a>
            <a href="{{ route('admin.services.edit', $package->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Package
            </a>
        </div>

    </div>

    {{-- Service Items List --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Service Items ({{ $package->package_item->count() }})</h3>
        </div>
        <div class="card-body">
            @if($package->package_item->isEmpty())
                <div style="text-align: center; padding: 48px 24px; color: #666;">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p style="font-size: 18px; margin-bottom: 8px;">No service items added yet</p>
                    <p style="margin-bottom: 24px;">Start by adding items to this package</p>
                    <a href="{{ route('admin.package.create', $package->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Item
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Service Name</th>
                                <th style="width: 45%;">Description</th>
                                <th style="width: 15%;">Added On</th>
                                <th style="width: 10%; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($package->package_item as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->service_name }}</strong>
                                    </td>
                                    <td>
                                        @if($item->description)
                                            {{ Str::limit($item->description, 100) }}
                                        @else
                                            <span style="color: #999; font-style: italic;">No description</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small style="color: #666;">
                                            {{ $item->created_at->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.package.edit', $item->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Delete Button --}}
                                            <form action="{{ route('admin.package.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Package Description Card --}}
    @if($package->description)
        <div class="card" style="margin-top: 24px;">
            <div class="card-header">
                <h3 class="card-title">Package Description</h3>
            </div>
            <div class="card-body">
                <p>{{ $package->description }}</p>
            </div>
        </div>
    @endif
@endsection