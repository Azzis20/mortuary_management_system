@extends('client.layouts.app')

@section('title', 'Book Service')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Book Service: {{ $package->package_name }}</h1>
        <p class="page-subtitle">Complete the form below to request this service</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title">Service Package Details</h2>
            <div class="package-price">₱{{ number_format($package->price, 2) }}</div>
        </div>
    </div>

    <p style="color: #718096; margin-bottom: 1.5rem;">{{ $package->description }}</p>

    <form action="{{ route('client.services.store') }}" method="POST" class="form-grid">
        @csrf
        <input type="hidden" name="package_id" value="{{ $package->id }}">

        <div class="form-group">
            <label for="deceased_id" class="form-label">
                Select Deceased Person <span class="required">*</span>
            </label>
            <select name="deceased_id" id="deceased_id" class="form-select" required>
                <option value="">-- Select Deceased --</option>
                @foreach($deceasedRecords as $deceased)
                    <option value="{{ $deceased->id }}" {{ old('deceased_id') == $deceased->id ? 'selected' : '' }}>
                        {{ $deceased->name }}
                    </option>
                @endforeach
            </select>
            @error('deceased_id')
                <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>



        <div style="margin-top: 2rem;">
            <h3 style="font-size: 1rem; font-weight: 600; color: #1a202c; margin-bottom: 1rem;">
                Body Retrieval Details
            </h3>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="address" class="form-label">
                    Retrieval Address <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    name="address" 
                    id="address" 
                    class="form-input"
                    value="{{ old('address') }}" 
                    placeholder="Enter complete address"
                    required>
                @error('address')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="location" class="form-label">
                    Location <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    name="location" 
                    id="location" 
                    class="form-input"
                    value="{{ old('location') }}" 
                    placeholder="e.g., Near City Hall, Beside Church"
                    required>
                @error('location')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="preferred_date" class="form-label">
                Preferred Date <span class="required">*</span>
            </label>
            <input 
                type="date" 
                name="preferred_date" 
                id="preferred_date" 
                class="form-input"
                value="{{ old('preferred_date') }}" 
                min="{{ date('Y-m-d') }}" 
                required>
            @error('preferred_date')
                <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Submit Request
            </button>
            <a href="{{ route('client.services.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<div class="card" style="background: #fef3c7; border-color: #fbbf24;">
    <div style="display: flex; gap: 1rem;">
        <div style="color: #f59e0b; font-size: 1.5rem;">ℹ️</div>
        <div>
            <h3 style="font-size: 0.95rem; font-weight: 600; color: #92400e; margin-bottom: 0.5rem;">
                Important Information
            </h3>
            <ul style="color: #78350f; font-size: 0.875rem; line-height: 1.6; list-style-position: inside;">
                <li>Your booking request will be set to <strong>pending</strong> status</li>
                <li>Admin will review and approve your request</li>
                <li>A bill will be automatically generated upon submission</li>
                <li>You will be notified once your request is processed</li>
            </ul>
        </div>
    </div>
</div>
@endsection