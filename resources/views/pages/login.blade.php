<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peaceful Rest</title>
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link">Back to Home</a>
        
        <h1>Please Login Your Account</h1>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Login Failed:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="Enter your email">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="Enter your password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </form>

        <p class="text-center mt-20">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </div>
</body>
</html>