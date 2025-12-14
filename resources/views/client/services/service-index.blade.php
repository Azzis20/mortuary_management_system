@extends('client.layouts.app')
@section('title', 'Service Packages')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Service Packages</h1>
        <p class="page-subtitle">Choose a service package for your deceased loved one</p>
    </div>
</div>
<div class="packages-grid">
    @forelse($packages as $package)
        <form action="{{ route('client.services.create', $package->id) }}" method="GET" style="width: 100%;">
            <button type="submit" class="package-card" style="width: 100%; text-align: left; background: white; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s;">
                <div class="package-header">
                    <h2 class="package-name">{{ $package->package_name }}</h2>
                    <div class="package-price">₱{{ number_format($package->price, 2) }}</div>
                </div>
                <p style="color: #718096; font-size: 0.9rem; margin-bottom: 1rem;">
                    {{ $package->description }}
                </p>
                
                {{-- Display Package Items instead of inclusions text field --}}
                @if($package->package_item->count() > 0)
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">
                        Package Inclusions:
                    </h3>
                    <ul class="package-features">
                        @foreach($package->package_item as $item)
                            <li class="package-feature">
                                <strong>{{ $item->service_name }}</strong>
                                @if($item->description)
                                    <span style="color: #718096; font-size: 0.85rem; display: block; margin-top: 0.25rem;">
                                        {{ $item->description }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
                
            
                @if($package->inclusions && $package->package_item->count() === 0)
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">
                        Package Inclusions:
                    </h3>
                    <ul class="package-features">
                        @foreach(explode("\n", $package->inclusions) as $inclusion)
                            @if(trim($inclusion))
                                <li class="package-feature">{{ trim($inclusion) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </button>
        </form>
    @empty
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3 class="empty-state-title">No Service Packages Available</h3>
                <p class="empty-state-text">There are currently no service packages available. Please check back later.</p>
            </div>
        </div>
    @endforelse
    
    <div>
        {{ $packages->links() }}
    </div>
</div>
@endsection