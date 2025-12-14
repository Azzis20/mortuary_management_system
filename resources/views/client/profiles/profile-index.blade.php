@extends('client.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="page-header">
    <h1 class="page-title">Profile</h1>
    <p class="page-subtitle">View your personal information</p>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="card-title">Profile Details</h2>
        <a href="{{ route('client.profile.edit',$profile->id) }}" class="btn btn-primary" style="text-decoration: none;">
            <svg style="width: 16px; height: 16px; margin-right: 0.5rem; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Profile
        </a>
    </div>

    <!-- Profile Picture Section -->
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e2e8f0;">
        <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 3px solid #e2e8f0; background: #f7fafc; display: flex; align-items: center; justify-content: center;">
            @if($profile->picture)
                <img src="{{ asset($profile->picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <svg style="width: 60px; height: 60px; color: #cbd5e0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 600; color: #1a202c; margin-bottom: 0.25rem;">
                {{ $user->name ?? 'N/A' }}
            </h3>
            <p style="color: #718096; font-size: 0.95rem;">
                {{ $user->email ?? 'N/A' }}
            </p>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="case-info">
        <div class="info-item">
            <span class="info-label">Full Name:</span>
            <span class="info-value">{{ $user->name ?? 'N/A' }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $user->email ?? 'N/A' }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Contact Number:</span>
            <span class="info-value">{{ $profile->contact ?? 'N/A' }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Date of Birth:</span>
            <span class="info-value">
                @if(isset($profile->date_of_birth))
                    {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('F d, Y') }}
                    <span style="color: #718096; font-size: 0.875rem;">({{ \Carbon\Carbon::parse($profile->date_of_birth)->age }} years old)</span>
                @else
                    N/A
                @endif
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Gender:</span>
            <span class="info-value">{{ $profile->gender ?? 'N/A' }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Address:</span>
            <span class="info-value">{{ $profile->address ?? 'N/A' }}</span>
        </div>

        @if(isset($profile->bio) && $profile->bio)
        <div class="info-item" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
            <span class="info-label">Bio / About:</span>
            <span class="info-value" style="line-height: 1.6;">{{ $profile->bio }}</span>
        </div>
        @endif
    </div>
</div>
@endsection