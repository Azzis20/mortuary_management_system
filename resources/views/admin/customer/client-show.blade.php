@extends('admin.layouts.app')

@section('title', 'Customer Profile')

@section('page-title', 'Customer Profile')

@section('content')

    {{-- Header Section --}}
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <h1 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0;">Client Profile</h1>
            <a href="{{ route('admin.client') }}" class="btn-minimal">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Profile Overview --}}
    <div class="card">
        <div style="display: flex; align-items: flex-start; gap: 32px;">
            {{-- Profile Picture --}}
            <div style="flex-shrink: 0;">
                @if($client->profile && $client->profile->picture)
                    <div class="image-container">
                            <img 
                                src="{{ asset($client->profile->picture) }}" 
                                alt="Document for {{ $client->name }}"
                                class="document-image"
                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;"
                            />
                    </div>
                @else
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 600;">
                        {{ strtoupper(substr($client->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Basic Info --}}
            <div style="flex-grow: 1;">
                <h2 style="margin: 0 0 4px 0; font-size: 20px; font-weight: 600; color: #1a1a1a;">{{ $client->name }}</h2>
                <p style="margin: 0 0 16px 0; color: #6b7280; font-size: 14px;">{{ $client->email }}</p>
                
                
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.client.booking', $client->id) }}" class="btn-minimal btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
                <!-- <button class="btn-minimal" onclick="window.print()">
                    <i class="fas fa-print"></i>
                </button> -->
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 24px;">
        
        {{-- Personal Information --}}
        <div class="info-card">
            <h3 class="info-card-title">Personal Information</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-key">Gender</span>
                    <span class="info-val">{{ $client->profile->gender ?? 'N/A' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-key">Date of Birth</span>
                    <span class="info-val">
                        @if($client->profile && $client->profile->date_of_birth)
                            {{ \Carbon\Carbon::parse($client->profile->date_of_birth)->format('M d, Y') }}
                            <span style="color: #9ca3af; font-size: 13px;">({{ \Carbon\Carbon::parse($client->profile->date_of_birth)->age }}y)</span>
                        @else
                            N/A
                        @endif
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Join Date</span>
                    <span class="info-val">{{ $client->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="info-card">
            <h3 class="info-card-title">Contact Information</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-key">Email</span>
                    <span class="info-val">
                        <a href="mailto:{{ $client->email }}" style="color: #3b82f6; text-decoration: none;">
                            {{ $client->email }}
                        </a>
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Phone</span>
                    <span class="info-val">
                        @if($client->profile && $client->profile->contact)
                            <a href="tel:{{ $client->profile->contact }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $client->profile->contact }}
                            </a>
                        @else
                            N/A
                        @endif
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Address</span>
                    <span class="info-val">{{ $client->profile->address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

  

    <style>

        .info-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-key {
            color: #6b7280;
            font-size: 14px;
            font-weight: 400;
        }

        .info-val {
            color: #1a1a1a;
            font-size: 14px;
            font-weight: 500;
            text-align: right;
            max-width: 65%;
            word-break: break-word;
        }


        @media print {
            .btn-minimal {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .profile-card > div {
                flex-direction: column;
                gap: 20px;
            }

            .info-val {
                max-width: 100%;
                text-align: left;
            }

            .info-item {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>

@endsection 