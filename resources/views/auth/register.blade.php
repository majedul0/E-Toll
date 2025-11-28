@extends('layouts.app')

@section('title', 'Registration - E-Toll')

@section('content')
<div style="max-width: 600px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">User Registration</h2>
        
        <form id="register-form" onsubmit="event.preventDefault(); handleRegistration();">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" id="full-name" class="form-input" placeholder="Enter your full name" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" id="phone" class="form-input" placeholder="01XXXXXXXXX" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" id="email" class="form-input" placeholder="your.email@example.com" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">NID Number</label>
                <input type="text" id="nid" class="form-input" placeholder="Enter NID number" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="password" class="form-input" placeholder="Create a strong password" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="confirm-password" class="form-input" placeholder="Confirm your password" required>
            </div>
            
            <button type="button" class="btn btn-primary" onclick="sendOTP()" style="width: 100%;">Send OTP</button>
            
            <div id="otp-section" class="hidden" style="margin-top: 2rem;">
                <div class="form-group">
                    <label class="form-label">Enter OTP</label>
                    <div class="otp-container">
                        <input type="text" class="otp-input" maxlength="1" required>
                        <input type="text" class="otp-input" maxlength="1" required>
                        <input type="text" class="otp-input" maxlength="1" required>
                        <input type="text" class="otp-input" maxlength="1" required>
                        <input type="text" class="otp-input" maxlength="1" required>
                        <input type="text" class="otp-input" maxlength="1" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Verify & Register</button>
            </div>
        </form>
    </div>
</div>

<script>
function handleRegistration() {
    if (!validateForm('register-form')) {
        return;
    }
    
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (password !== confirmPassword) {
        showAlert('Passwords do not match', 'error');
        return;
    }
    
    verifyOTP();
}
</script>
@endsection

