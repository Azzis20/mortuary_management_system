@extends('client.layouts.app')

@section('title', 'Register Deceased')

@section('content')
<div class="page-header">
    <h1 class="page-title">Register Deceased Person</h1>
    <p class="page-subtitle">Please provide the required information to create a new case</p>
</div>

<!-- Display Validation Errors -->
@if($errors->any())
    <div class="alert alert-error">
        <strong>Please fix the following errors:</strong>
        <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('client.decease.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Deceased Person Information -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Deceased Person Information</h2>
        </div>

        <div class="form-grid">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" 
                        name="full_name" 
                        class="form-input @error('full_name') error @enderror" 
                        placeholder="Enter full name"
                        value="{{ old('full_name') }}" 
                        required>
                    @error('full_name')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Gender <span class="required">*</span></label>
                    <select name="gender" class="form-select @error('gender') error @enderror" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Date of Birth <span class="required">*</span></label>
                    <input type="date" 
                        name="date_of_birth" 
                        class="form-input @error('date_of_birth') error @enderror"
                        value="{{ old('date_of_birth') }}" 
                        required>
                    @error('date_of_birth')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date of Death <span class="required">*</span></label>
                    <input type="date" 
                        name="date_of_death" 
                        class="form-input @error('date_of_death') error @enderror"
                        value="{{ old('date_of_death') }}" 
                        required>
                    @error('date_of_death')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Cause of Death (Optional)</label>
                <input type="text" 
                    name="cause_of_death" 
                    class="form-input @error('cause_of_death') error @enderror" 
                    placeholder="Enter cause of death if known"
                    value="{{ old('cause_of_death') }}">
                @error('cause_of_death')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Document (Optional)</label>
                <input type="file" 
                    name="document" 
                    class="form-input @error('document') error @enderror"
                    accept=".pdf,.jpg,.jpeg,.png">
                <small style="color: #718096; font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    Accepted formats: PDF, JPG, PNG (Max: 2MB)
                </small>
                @error('document')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Next of Kin Information -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Next of Kin Information</h2>
        </div>

        <div class="form-grid">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" 
                        name="kin_name" 
                        class="form-input @error('kin_name') error @enderror" 
                        placeholder="Enter next of kin name"
                        value="{{ old('kin_name') }}" 
                        required>
                    @error('kin_name')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Relationship <span class="required">*</span></label>
                    <select name="kin_relationship" class="form-select @error('kin_relationship') error @enderror" required>
                        <option value="">Select Relationship</option>
                        <option value="spouse" {{ old('kin_relationship') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="child" {{ old('kin_relationship') == 'child' ? 'selected' : '' }}>Child</option>
                        <option value="parent" {{ old('kin_relationship') == 'parent' ? 'selected' : '' }}>Parent</option>
                        <option value="sibling" {{ old('kin_relationship') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                        <option value="other" {{ old('kin_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('kin_relationship')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Contact Number <span class="required">*</span></label>
                    <input type="tel" 
                        name="kin_phone" 
                        class="form-input @error('kin_phone') error @enderror" 
                        placeholder="e.g., 09171234567"
                        value="{{ old('kin_phone') }}" 
                        required>
                    @error('kin_phone')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address (Optional)</label>
                    <input type="email" 
                        name="kin_email" 
                        class="form-input @error('kin_email') error @enderror" 
                        placeholder="email@example.com"
                        value="{{ old('kin_email') }}">
                    @error('kin_email')
                        <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Address <span class="required">*</span></label>
                <textarea name="kin_address" 
                    class="form-textarea @error('kin_address') error @enderror" 
                    placeholder="Enter complete address" 
                    required>{{ old('kin_address') }}</textarea>
                @error('kin_address')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions " >
        <button type="submit" class="btn btn-primary" style="width: 150px; display: flex; justify-content: center; align-items: center;">   Register   </button>
        <a href="{{ route('client.decease.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection