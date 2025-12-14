@extends('admin.layouts.app')

@section('title', 'Create')

@section('page-title', 'Create Package')

<!-- @push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/package-form.css') }}">
@endpush -->

@section('content')
    <div class="page-header">
        <h1>Create Package</h1>
        <p>Add new package to your service offerings</p>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="package_name">Package Name <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="package_name" 
                    name="package_name" 
                    value="{{ old('package_name') }}"
                    class="form-input @error('package_name') error @enderror"
                    placeholder="e.g., Premium Monthly Plan"
                    required>
                @error('package_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price <span class="required">*</span></label>
                <div class="input-with-prefix">
                    <span class="prefix">₱</span>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}"
                        step="0.01" 
                        min="0"
                        class="form-input with-prefix @error('price') error @enderror"
                        placeholder="999.00"
                        required>
                </div>
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description <span class="optional">(Optional)</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="form-input @error('description') error @enderror"
                    placeholder="Key features and benefits of this package">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Create Package</button>
                <a href="{{ route('admin.services.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection


<style>
    /* Package Form Styles - Clean & Minimalistic */

/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 0.5rem 0;
}

.page-header p {
    font-size: 0.938rem;
    color: #666;
    margin: 0;
}

/* Form Container */
.form-container {
    background: #ffffff;
    border-radius: 8px;
    padding: 5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    max-width: 1000px;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
    max-width: 600px;
    
}

.form-group:last-of-type {
    margin-bottom: 2rem;
}

/* Labels */
.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.required {
    color: #dc2626;
}

.optional {
    color: #999;
    font-weight: 400;
}

/* Input Fields */
.form-input {
    width: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.938rem;
    line-height: 1.5;
    color: #1a1a1a;
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    transition: all 0.15s ease;
    font-family: inherit;
}

.form-input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-input.error {
    border-color: #dc2626;
}

.form-input.error:focus {
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* Textarea */
textarea.form-input {
    resize: vertical;
    min-height: 100px;
}

/* Input with Prefix (Price Field) */
.input-with-prefix {
    position: relative;
    display: flex;
    align-items: center;
}

.prefix {
    position: absolute;
    left: 0.875rem;
    font-size: 0.938rem;
    color: #666;
    pointer-events: none;
    font-weight: 500;
}

.form-input.with-prefix {
    padding-left: 2rem;
}

/* Error Messages */
.error-message {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.813rem;
    color: #dc2626;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 0.75rem;
    padding-top: 0.5rem;
}

/* Buttons */
.btn-primary,
.btn-secondary {
    padding: 0.625rem 1.5rem;
    font-size: 0.938rem;
    font-weight: 500;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    width: 200px;
}

.btn-primary {
    background-color: #4f46e5;
    color: #ffffff;
    flex: 1;
    max-width: 400px;

}

.btn-primary:hover {
    background-color: #4338ca;
}

.btn-primary:active {
    background-color: #3730a3;
}

.btn-secondary {
    background-color: #f3f4f6;
    color: #4b5563;
}

.btn-secondary:hover {
    background-color: #e5e7eb;
}

.btn-secondary:active {
    background-color: #d1d5db;
}

/* Responsive Design */
@media (max-width: 640px) {
    .form-container {
        padding: 1.5rem;
    }

    .page-header h1 {
        font-size: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
    }
}
</style>
