@extends('layouts.app')

@section('title', 'Login - E-Toll')

@section('content')
<!---- Login Functionality--- -->
<div style="max-width: 500px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">Citizen Login</h2>
        
        <form id="login-form" onsubmit="event.preventDefault(); handleLogin();">
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" id="login-identifier" class="form-input" placeholder="Enter phone number" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="login-password" class="form-input" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-gray);">Don't have an account? <a href="/register" style="color: var(--primary-green);">Register here</a></p>
        </div>
    </div>
</div>

<script>
function handleLogin() {
    if (!validateForm('login-form')) {
        return;
    }
    
    const identifier = document.getElementById('login-identifier').value;
    const password = document.getElementById('login-password').value;
    
    // Simulate login
    showAlert('Logging in...', 'info');
    
    setTimeout(() => {
        showAlert('Login successful!', 'success');
        window.location.href = '/dashboard';
    }, 1000);
}
</script>
@endsection

