<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Peaceful Rest</title>
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
</head>

<body>

    <!-- ✅ Terms & Conditions Modal -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeTermsModal()">&times;</span>

            <h2>Terms & Conditions</h2>

            <div class="modal-body">
                <p>
                   By using the Peaceful Rest Mortuary Management System, you acknowledge and agree to the following:
                </p>

                <ul>
                    <li>• This system is used to manage mortuary and funeral service records.</li>
                    <li>• Personal information provided by you (including names, contact details, and related records) will be collected and stored for service, legal, and administrative purposes.</li>
                    <li>• All personal and deceased records are handled with confidentiality and care.</li>
                    <li>• Your information will only be accessed by authorized personnel and will not be shared unlawfully.</li>
                    <li>• You are responsible for providing accurate and truthful information.</li>
                    <li>• Misuse of the system or submission of false information may result in service denial.</li>
                    <li>• The system is provided “as is” without warranties.</li>
                    <li>Please read and understand these terms before proceeding.</li>
                 
                </ul>

                <p>Please read these terms carefully before registering.</p>
            </div>

            <div class="modal-footer" style="padding-top:16px;">
                <button class="btn btn-secondary" onclick="closeTermsModal()">
                    Close
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('home') }}" class="back-link">Back to Home</a>

        <h1>Create an Account</h1>

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

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation"
                       name="password_confirmation" required>
            </div>

            <!-- ✅ Terms Checkbox (Modal Trigger) -->
            <div class="form-group terms-group">
                <label class="terms-label">
                    <input type="checkbox" name="terms" required>
                    I agree to the
                    <a href="javascript:void(0)" onclick="openTermsModal()">
                        Terms & Conditions
                    </a>
                </label>

                @error('terms')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </form>

        <p class="text-center mt-20">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>
    </div>

    <!-- ✅ JavaScript -->
    <script>
        function openTermsModal() {
            document.getElementById('termsModal').style.display = 'block';
        }

        function closeTermsModal() {
            document.getElementById('termsModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('termsModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>
</html>
<style>
    /* Modal Background */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
}

/* Modal Box */
.modal-content {
    background: #fff;
    width: 90%;
    max-width: 800px;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    position: relative;
}

/* Close Button */
.modal .close {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
}

/* Modal Body */
.modal-body {
    max-height: 300px;
    overflow-y: auto;
    margin-top: 10px;
}

/* Terms checkbox */
.terms-group {
    margin-top: 15px;
    font-size: 14px;
}

.terms-label {
    display: flex;
    align-items: center;
    gap: 8px;
}

</style>