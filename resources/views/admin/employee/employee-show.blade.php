@extends('admin.layouts.app')

@section('title', 'Employee Profile')

@section('page-title', 'Employee Profile')

@section('content')

    {{-- Header Section --}}
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <h1 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0;">Employee Profile</h1>
            <a href="{{ route('admin.employee') }}" class="btn-minimal">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Profile Overview --}}
    <div class="profile-card">
        <div style="display: flex; align-items: flex-start; gap: 32px;">
            {{-- Profile Picture --}}
            <div style="flex-shrink: 0;">
                @if($employee->profile && $employee->profile->picture)
                    <img 
                                src="{{ asset($client->profile->picture) }}" 
                                alt="Document for {{ $client->name }}"
                                class="document-image"
                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;"
                    />
                @else
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 600;">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>
                @endif

              <!-- / -->
               
            </div>

            {{-- Basic Info --}}
            <div style="flex-grow: 1;">
                <h2 style="margin: 0 0 4px 0; font-size: 20px; font-weight: 600; color: #1a1a1a;">{{ $employee->name }}</h2>
                <p style="margin: 0 0 16px 0; color: #6b7280; font-size: 14px;">{{ $employee->email }}</p>
                
                <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                    <div>
                        <span style="font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">ID</span>
                        <p style="margin: 2px 0 0 0; font-size: 14px; color: #1a1a1a; font-weight: 500;">{{ $employee->id }}</p>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Role</span>
                        <p style="margin: 2px 0 0 0; font-size: 14px; color: #1a1a1a; font-weight: 500;">{{ ucfirst($employee->accountType ?? 'N/A') }}</p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn-minimal btn-primary">
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
                    <span class="info-val">{{ $employee->profile->gender ?? 'N/A' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-key">Date of Birth</span>
                    <span class="info-val">
                        @if($employee->profile && $employee->profile->date_of_birth)
                            {{ \Carbon\Carbon::parse($employee->profile->date_of_birth)->format('M d, Y') }}
                            <span style="color: #9ca3af; font-size: 13px;">({{ \Carbon\Carbon::parse($employee->profile->date_of_birth)->age }}y)</span>
                        @else
                            N/A
                        @endif
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Join Date</span>
                    <span class="info-val">{{ $employee->created_at->format('M d, Y') }}</span>
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
                        <a href="mailto:{{ $employee->email }}" style="color: #3b82f6; text-decoration: none;">
                            {{ $employee->email }}
                        </a>
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Phone</span>
                    <span class="info-val">
                        @if($employee->profile && $employee->profile->contact)
                            <a href="tel:{{ $employee->profile->contact }}" style="color: #3b82f6; text-decoration: none;">
                                {{ $employee->profile->contact }}
                            </a>
                        @else
                            N/A
                        @endif
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-key">Address</span>
                    <span class="info-val">{{ $employee->profile->address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

  

    <style>
        .profile-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 24px;
            border: 1px solid #e5e7eb;
        }

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