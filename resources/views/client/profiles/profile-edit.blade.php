@extends('client.layouts.app')
@section('title', 'Edit Profile')

@section('content')
<div class="profile-edit-container">
    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <p class="page-subtitle">Update your personal information</p>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Profile Form --}}
    <div class="card">
        <form action="{{ route('client.profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-content">
                {{-- Profile Picture --}}
                <div class="profile-picture-section">
                    <div class="profile-picture-wrapper">
                        <div id="imagePreview" class="profile-picture">
                            @if($profile->picture)
                                <img src="{{ asset($profile->picture) }}" alt="Profile Picture">
                            @else
                                <div class="placeholder-image">No Image</div>
                            @endif
                        </div>
                        <label for="picture" class="btn btn-primary">
                            Change Photo
                        </label>
                    </div>
                    <input type="file" id="picture" name="picture" accept="image/jpeg,image/jpg,image/png" class="file-input">
                    <p class="help-text">JPG, JPEG, PNG - Max 2MB</p>
                </div>

                {{-- Contact Number --}}
                <div class="form-group">
                    <label for="contact" class="form-label">
                        Contact Number <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="contact" 
                        name="contact" 
                        value="{{ old('contact', $profile->contact) }}"
                        placeholder="e.g., 09123456789"
                        class="form-input @error('contact') error @enderror"
                        required
                    >
                    @error('contact')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date of Birth --}}
                <div class="form-group">
                    <label for="date_of_birth" class="form-label">
                        Date of Birth <span class="required">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="date_of_birth" 
                        name="date_of_birth" 
                        value="{{ old('date_of_birth', $profile->date_of_birth) }}"
                        max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                        class="form-input @error('date_of_birth') error @enderror"
                        required
                    >
                    @error('date_of_birth')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="form-group">
                    <label class="form-label">
                        Gender <span class="required">*</span>
                    </label>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input 
                                type="radio" 
                                name="gender" 
                                value="male" 
                                {{ old('gender', $profile->gender) == 'male' ? 'checked' : '' }}
                                required
                            >
                            <span>Male</span>
                        </label>

                        <label class="gender-option">
                            <input 
                                type="radio" 
                                name="gender" 
                                value="female" 
                                {{ old('gender', $profile->gender) == 'female' ? 'checked' : '' }}
                                required
                            >
                            <span>Female</span>
                        </label>

                        <label class="gender-option">
                            <input 
                                type="radio" 
                                name="gender" 
                                value="other" 
                                {{ old('gender', $profile->gender) == 'other' ? 'checked' : '' }}
                                required
                            >
                            <span>Other</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <label for="address" class="form-label">
                        Address <span class="required">*</span>
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="3"
                        placeholder="Enter your complete address"
                        class="form-textarea @error('address') error @enderror"
                        required
                    >{{ old('address', $profile->address) }}</textarea>
                    @error('address')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('client.profile.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Container */
.profile-edit-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Alerts */
.alert {
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    border-left: 4px solid;
}

.alert-success {
    background-color: #f0fdf4;
    border-color: #22c55e;
    color: #166534;
}

.alert-error {
    background-color: #fef2f2;
    border-color: #ef4444;
    color: #991b1b;
}

.alert ul {
    margin-top: 0.5rem;
    padding-left: 1.5rem;
}

.alert li {
    margin-top: 0.25rem;
}

/* Form Content */
.form-content {
    padding: 2rem;
}

/* Profile Picture Section */
.profile-picture-section {
    text-align: center;
    padding-bottom: 2rem;
    margin-bottom: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.profile-picture-wrapper {
    display: inline-block;
    position: relative;
}

.profile-picture {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #e5e7eb;
    background-color: #f9fafb;
    margin: 0 auto 1rem;
}

.profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.875rem;
}

/* .upload-btn {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    background-color: #121212;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background-color 0.2s;
}

.upload-btn:hover {
    background-color: #2563eb;
} */

.file-input {
    display: none;
}

.help-text {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.error,
.form-textarea.error {
    border-color: #ef4444;
}

.error-text {
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #ef4444;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

/* Gender Options */
.gender-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.gender-option {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    transition: border-color 0.2s, background-color 0.2s;
}

.gender-option:hover {
    border-color: #212121;
}

.gender-option input[type="radio"] {
    margin-right: 0.5rem;
}

.gender-option input[type="radio"]:checked + span {
    font-weight: 600;
}

.gender-option:has(input:checked) {
    border-color: #121211;
    background-color: #fefefe;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem 2rem;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background-color: #121212;
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #6e6e6eff;
}

.btn-secondary {
    background-color: white;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background-color: #f9fafb;
}

/* Responsive */
@media (max-width: 640px) {
    .gender-options {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
document.getElementById('picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = 
                '<img src="' + e.target.result + '" alt="Preview">';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection