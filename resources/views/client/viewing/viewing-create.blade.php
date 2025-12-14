@extends('client.layouts.app')

@section('title', 'Set Viewing Schedule')

@section('content')

<div>
    <h1 class="page-title">Set Viewing Schedule</h1>
    <p class="page-subtitle">Schedule a viewing for booking #{{ $booking->id }}</p>
</div>

<!-- Booking Information Card -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Booking Information</h2>
    </div>
    
    <div class="case-info">
        <div class="info-item">
            <span class="info-label">Booking ID:</span>
            <span class="info-value">#{{ $booking->id }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Package:</span>
            <span class="info-value">{{ $booking->package->package_name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Deceased Name:</span>
            <span class="info-value">{{ $booking->deceased->name }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Created Date:</span>
            <span class="info-value">{{ $booking->created_at->format('F d, Y') }}</span>
        </div>
    </div>
</div>

<!-- Viewing Schedule Form -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Viewing Schedule Details</h2>
    </div>
    
    <form action="{{ route('client.viewing.store', $booking->id) }}" method="POST">
        @csrf
        
        <div class="form-grid">
            <!-- Viewing Date -->
            <div class="form-group">
                <label for="viewing_date" class="form-label">
                    Viewing Date <span class="required">*</span>
                </label>
                <input 
                    type="date" 
                    id="viewing_date" 
                    name="viewing_date" 
                    class="form-input @error('viewing_date') error @enderror"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('viewing_date') }}"
                    required
                >
                @error('viewing_date')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Viewing Type -->
            <div class="form-group">
                <label for="viewing_type" class="form-label">
                    Viewing Type <span class="required">*</span>
                </label>
                <select 
                    id="viewing_type" 
                    name="viewing_type" 
                    class="form-select @error('viewing_type') error @enderror"
                    required
                >
                    <option value="">Select viewing type</option>
                    <option value="Public" {{ old('viewing_type') === 'Public' ? 'selected' : '' }}>Public</option>
                    <option value="Private" {{ old('viewing_type') === 'Private' ? 'selected' : '' }}>Private</option>
                    <option value="Family Only" {{ old('viewing_type') === 'Family Only' ? 'selected' : '' }}>Family Only</option>
                </select>
                @error('viewing_type')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="location" class="form-label">
                    Location Name
                </label>
                <input 
                    type="text" 
                    id="location" 
                    name="location" 
                    class="form-input @error('location') error @enderror"
                    placeholder="e.g., Chapel A, Main Hall"
                    value="{{ old('location') }}"
                >
                <small style="color: #718096; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Optional: Specific chapel, hall, or room name
                </small>
                @error('location')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address" class="form-label">
                    Full Address
                </label>
                <textarea 
                    id="address" 
                    name="address" 
                    class="form-textarea @error('address') error @enderror"
                    placeholder="Enter complete address if viewing is at a specific location"
                    rows="3"
                >{{ old('address') }}</textarea>
                <small style="color: #718096; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Optional: Full address including street, city, and postal code
                </small>
                @error('address')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Special Requests -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="special_requests" class="form-label">
                    Special Requests
                </label>
                <textarea 
                    id="special_requests" 
                    name="special_requests" 
                    class="form-textarea @error('special_requests') error @enderror"
                    placeholder="e.g., Favorite music, photo display preferences, flower arrangements"
                    rows="4"
                >{{ old('special_requests') }}</textarea>
                <small style="color: #718096; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Optional: Any special arrangements or preferences for the viewing
                </small>
                @error('special_requests')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('client.viewing.index') }}" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Set Schedule
            </button>
        </div>
    </form>
</div>

@endsection