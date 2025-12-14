@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('page-title', 'Edit Booking Details')

@section('content')
    <div class="card">
        <h3>Edit Booking #{{ $booking->id }}</h3>
        
        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Booking ID</label>
                <input type="text" value="{{ $booking->id }}" disabled class="form-control">
            </div>
            
            <div class="form-group">
                <label>Deceased Name</label>
                <input type="text" value="{{ $booking->deceased->name ?? 'N/A' }}" disabled class="form-control">
            </div>
            
            <div class="form-group">
                <label>Next of Kin</label>
                <input type="text" value="{{ optional($booking->deceased->nextOfKins)->name ?? 'N/A' }}" disabled class="form-control">
            </div>
            
            <div class="form-group">
                <label>Date of Admission</label>
                <input type="text" value="{{ $booking->created_at->format('Y-m-d') }}" disabled class="form-control">
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Dispatch" {{ $booking->status == 'Dispatch' ? 'selected' : '' }}>Dispatch</option>
                    <option value="InCare" {{ $booking->status == 'InCare' ? 'selected' : '' }}>InCare</option>
                    <option value="Viewing" {{ $booking->status == 'Viewing' ? 'selected' : '' }}>Viewing</option>
                    <option value="Released" {{ $booking->status == 'Released' ? 'selected' : '' }}>Released</option>
                    
                    
                </select>   
            </div>

        
             
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Booking</button>
                <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

<style>
    .card {
        padding: 20px;
        max-width: 800px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn-primary {
        background-color: #4CAF50;
    }
    
    .btn-primary:hover {
        background-color: #45a049;
    }
    
    .btn-secondary {
        background-color: #757575;
    }
    
    .btn-secondary:hover {
        background-color: #616161;
    }
</style>