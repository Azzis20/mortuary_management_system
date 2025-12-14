@extends('client.layouts.app')

@section('title', 'Deceased Records')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Deceased Records</h1>
            <p class="page-subtitle">View and manage your registered deceased persons</p>
        </div>
        <a href="{{ route('client.decease.create') }}" class="btn btn-primary">
            + Add Deceased
        </a>
    </div>
</div>

@if($deceaseds->isEmpty())
    <!-- Empty State -->
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 class="empty-state-title">No Deceased Records Yet</h3>
            <p class="empty-state-text">You haven't registered any deceased persons. Click the button above to get started.</p>
            <a href="{{ route('client.decease.create') }}" class="btn btn-primary" style="margin-top: 1.5rem;">
                Register First Deceased
            </a>
        </div>
    </div>
@else
    <!-- Deceased Records Grid -->
    @foreach($deceaseds as $deceased)
        <div class="card" style="position: relative;">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="card-title">{{ $deceased->name }}</h2>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('client.decease.show', $deceased->id) }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                            View Details
                        </a>
                        <a href="{{ route('client.decease.edit', $deceased->id) }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                            Edit
                        </a>
                        <form action="{{ route('client.decease.destroy', $deceased->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background: #dc2626; color: white; border: none;height: 40px;">
                                Delete
                            </button>
                        </form>
                        <!-- <a href="{{ route('client.services.index') }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                            Select Services
                        </a> -->
                    </div>
                </div>
            </div>

            <!-- Clickable Card Body -->
            <a href="{{ route('client.decease.show', $deceased->id) }}" style="text-decoration: none; color: inherit; display: block;">
                <div class="case-info" style="cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                    <!-- Deceased Information -->
                    <div style="margin-bottom: 1rem;">
                        <h3 style="font-size: 0.95rem; font-weight: 600; color: #4a5568; margin-bottom: 0.75rem;">Deceased Information</h3>
                        
                        <div class="info-item">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value">{{ $deceased->name }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Gender:</span>
                            <span class="info-value">{{ ucfirst($deceased->gender) }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Date of Birth:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($deceased->date_of_birth)->format('F d, Y') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Date of Death:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($deceased->date_of_death)->format('F d, Y') }}</span>
                        </div>

                        @if($deceased->cause_of_death)
                        <div class="info-item">
                            <span class="info-label">Cause of Death:</span>
                            <span class="info-value">{{ $deceased->cause_of_death }}</span>
                        </div>
                        @endif

                        @if($deceased->document)
                        <div class="info-item">
                            <span class="info-label">Document:</span>
                            <span class="info-value">
                                <span style="color: #3b82f6;">
                                    ✓ Document Available
                                </span>
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Registration Date -->
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                        <div class="info-item">
                            <span class="info-label">Registered On:</span>
                            <span class="info-value" style="color: #718096;">
                                {{ $deceased->created_at->format('F d, Y \a\t g:i A') }}
                            </span>
                        </div>
                    </div>

                    <!-- Click Hint -->
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0; text-align: center;">
                        <span style="color: #3b82f6; font-size: 0.875rem;">
                            Click to view full details →
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    <!-- Pagination -->
    @if($deceaseds->hasPages())
        <div style="margin-top: 2rem;">
            {{ $deceaseds->links() }}
        </div>
    @endif
@endif
@endsection