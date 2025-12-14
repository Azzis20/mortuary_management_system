
@extends('admin.layouts.app')

@section('title', 'Service and Package')

@section('page-title', 'Service and Package')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Service and Package Management</h3>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary"> Add New Package </a>
        </div>
    </div>
   


    <div class="packages-grid">
    @forelse($packages as $package)
        <a href="{{ route('admin.services.edit', $package->id) }}" class="package-card-link">
            <div class="package-card">
                <div class="package-header">
                    <h2 class="package-name">{{ $package->package_name }}</h2>
                    <div class="package-price">₱{{ number_format($package->price, 2) }}</div>
                </div>

                <p class="package-description">
                    {{ $package->description }}
                </p>

            @if($package->package_item && $package->package_item->count() > 0)
                <h3 class="inclusions-title">
                    Package Inclusions:
                </h3>
                <ul class="package-features">
                    @foreach($package->package_item as $item)
                        <li class="package-feature">
                            ✅ {{ $item->service_name }} - {{ $item->description }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="cta-indicator">
                Select Package &rarr;
            </div>
        </div>
    @empty
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3 class="empty-state-title">No Service Packages Available</h3>
                <p class="empty-state-text">There are currently no service packages available. Please check back later.</p>
            </div>
        </div>
    @endforelse
</div>


@endsection

<style>
/* Basic styling to make the link look like a card and be clickable */
.package-card-link {
    text-decoration: none; /* Remove underline from the link */
    color: inherit; /* Inherit text color */
    display: block; /* Make the link occupy the whole grid item */
    transition: transform 0.2s, box-shadow 0.2s; /* Smooth hover effects */
}

.package-card {
    border: 1px solid #e2e8f0; /* Light gray border */
    border-radius: 8px ; /* Rounded corners */
    padding: 1.5rem;
    background-color: #ffffff; /* White background */
    height: 30%; /* Ensure card fills the link container */
    display: flex;
    flex-direction: column;
    margin-top:1rem;
    margin-below:1rem;
    
}

/* Hover effect for the card */
.package-card-link:hover .package-card {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Soft shadow */
    transform: translateY(-5px); /* Lift the card slightly */
}

/* General package element styling */
.package-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.package-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748; /* Darker heading color */
    margin: 0;
}

.package-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #48bb78; /* Green for price */
}

.package-description {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    flex-grow: 1; /* Allows it to push the inclusions/CTA down */
  
}

.inclusions-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.75rem;
    margin-top: 1rem; /* Added margin-top for separation */
}

.package-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0; /* Margin at the bottom before CTA */
}

.package-feature {
    font-size: 0.875rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

/* New CTA indicator style */
.cta-indicator {
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
    text-align: right;
    font-weight: 600;
    color: #4299e1; /* Blue for the CTA */
    margin-top: auto; /* Pushes the indicator to the bottom */
}

.card {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.button-right {
    text-align: right;
    margin-top: 5px;
}

.btn {
    background: #1a1a1a;
    color: white;
    padding: 10px 16px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
}
</style>