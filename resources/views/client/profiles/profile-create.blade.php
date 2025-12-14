<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Registration</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Complete Your Profile</h1>
            <p class="subtitle">Fill in your information to get started</p>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="error-box">
                    <strong>Errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('client.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Profile Picture --}}
                <div class="picture-section">
                    <div id="imagePreview" class="picture-box">
                        <span>No Photo</span>
                    </div>
                    <label for="picture" class="upload-label">Choose Photo</label>
                    <input type="file" id="picture" name="picture" accept="image/jpeg,image/jpg,image/png" hidden>
                    <small>Max 2MB</small>
                </div>

                {{-- Contact Number --}}
                <div class="field">
                    <label>Contact Number <span class="req">*</span></label>
                    <input 
                        type="text" 
                        name="contact" 
                        value="{{ old('contact') }}"
                        placeholder="09123456789"
                        required
                    >
                    @error('contact')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Date of Birth --}}
                <div class="field">
                    <label>Date of Birth <span class="req">*</span></label>
                    <input 
                        type="date" 
                        name="date_of_birth" 
                        value="{{ old('date_of_birth') }}"
                        max="{{ date('Y-m-d') }}"
                        required
                    >
                    @error('date_of_birth')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="field">
                    <label>Gender <span class="req">*</span></label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                            Male
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                            Female
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} required>
                            Other
                        </label>
                    </div>
                    @error('gender')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="field">
                    <label>Address <span class="req">*</span></label>
                    <textarea 
                        name="address" 
                        rows="3"
                        placeholder="Your complete address"
                        required
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="submit-btn">Save Profile</button>
            </form>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .error-box {
            background: #fee;
            border-left: 3px solid #e33;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #c00;
        }

        .error-box ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        .picture-section {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .picture-box {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f0f0f0;
            border: 2px solid #ddd;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
            overflow: hidden;
        }

        .picture-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-label {
            display: inline-block;
            padding: 8px 20px;
            background: #333;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }

        .upload-label:hover {
            background: #555;
        }

        small {
            display: block;
            margin-top: 8px;
            color: #999;
            font-size: 12px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
        }

        .req {
            color: #e33;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: border 0.2s;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #333;
        }

        textarea {
            resize: vertical;
        }

        .error {
            color: #e33;
            font-size: 12px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-weight: normal;
        }

        input[type="radio"] {
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #555;
        }

        @media (max-width: 600px) {
            .card {
                padding: 30px 20px;
            }

            .radio-group {
                flex-direction: column;
                gap: 12px;
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
</body>
</html>