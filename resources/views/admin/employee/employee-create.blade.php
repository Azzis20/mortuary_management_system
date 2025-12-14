@extends('admin.layouts.app')

@section('title', 'Add New Employee')

@section('page-title', 'Employee Management')

@section('content')

{{-- Header --}}
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0;">Add New Employee</h1>
        <a href="{{ route('admin.employee') }}" class="btn-minimal">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('admin.employee.store') }}" method="POST">
        @csrf

        {{-- Account Information Section --}}
        <div class="form-section">
            <h3 class="section-title">Account Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name <span style="color: #dc2626;">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-input @error('name') error @enderror" 
                        value="{{ old('name') }}" 
                        placeholder="Enter full name"
                        required
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span style="color: #dc2626;">*</span></label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input @error('email') error @enderror" 
                        value="{{ old('email') }}" 
                        placeholder="email@example.com"
                        required
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="accountType">Account Type <span style="color: #dc2626;">*</span></label>
                    <select 
                        name="accountType" 
                        id="accountType" 
                        class="form-input @error('accountType') error @enderror"
                        required
                    >
                        <option value="">Select role</option>
                        <option value="admin" {{ old('accountType') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('accountType') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="driver" {{ old('accountType') == 'driver' ? 'selected' : '' }}>Driver</option>
                        <option value="mortician" {{ old('accountType') == 'mortician' ? 'selected' : '' }}>Mortician</option>
                        <option value="embalmer" {{ old('accountType') == 'embalmer' ? 'selected' : '' }}>Embalmer</option>
                    </select>
                    @error('accountType')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact">Contact Number</label>
                    <input 
                        type="text" 
                        name="contact" 
                        id="contact" 
                        class="form-input @error('contact') error @enderror" 
                        value="{{ old('contact') }}" 
                        placeholder="+63 912 345 6789"
                    >
                    @error('contact')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Personal Information Section --}}
        <div class="form-section">
            <h3 class="section-title">Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select 
                        name="gender" 
                        id="gender" 
                        class="form-input @error('gender') error @enderror"
                    >
                        <option value="">Select gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input 
                        type="date" 
                        name="date_of_birth" 
                        id="date_of_birth" 
                        class="form-input @error('date_of_birth') error @enderror" 
                        value="{{ old('date_of_birth') }}"
                    >
                    @error('date_of_birth')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea 
                    name="address" 
                    id="address" 
                    class="form-input @error('address') error @enderror" 
                    rows="3"
                    placeholder="Enter complete address"
                >{{ old('address') }}</textarea>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Security Section --}}
        <div class="form-section">
            <h3 class="section-title">Security</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <span style="color: #dc2626;">*</span></label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input @error('password') error @enderror" 
                        placeholder="Min. 8 characters"
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span style="color: #dc2626;">*</span></label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="form-input" 
                        placeholder="Re-enter password"
                        required
                    >
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn-minimal btn-primary">
                <i class="fa-solid fa-user-plus"></i> Add Employee
            </button>
            <a href="{{ route('admin.employee') }}" class="btn-minimal">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 32px;
        border: 1px solid #e5e7eb;
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0 0 20px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-input {
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        color: #1a1a1a;
        background: #ffffff;
        transition: all 0.15s ease;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input.error {
        border-color: #dc2626;
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 80px;
    }

    select.form-input {
        cursor: pointer;
    }

    .error-message {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: #dc2626;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 32px;
        border-top: 1px solid #f3f4f6;
    }

    .btn-minimal {
        padding: 10px 20px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #6b7280;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-minimal:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #1a1a1a;
    }

    .btn-minimal.btn-primary {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #ffffff;
    }

    .btn-minimal.btn-primary:hover {
        background: #2563eb;
        border-color: #2563eb;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-minimal {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection