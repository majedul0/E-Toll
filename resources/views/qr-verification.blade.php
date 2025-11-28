@extends('layouts.app')

@section('title', 'QR Verification - E-Toll')

@section('content')
<div style="max-width: 600px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">QR Code Verification</h2>
        <p style="color: var(--text-gray); margin-bottom: 2rem;">Scan or enter QR code to verify payment</p>
        
        <div class="form-group">
            <label class="form-label">QR Code</label>
            <input type="text" id="qr-input" class="form-input" placeholder="Scan QR code or enter transaction ID" required>
            <button class="btn" onclick="openScanner()" style="width: 100%; margin-top: 0.5rem;">📷 Open Scanner</button>
        </div>
        
        <button class="btn btn-primary" onclick="verifyQR()" style="width: 100%;">Verify QR Code</button>
        
        <div id="verification-result" class="hidden" style="margin-top: 2rem;">
            <div id="result-content"></div>
        </div>
    </div>
</div>

<script>
function openScanner() {
    // In production, this would open a camera scanner
    showAlert('Camera scanner would open here', 'info');
}

function verifyQR() {
    const qrInput = document.getElementById('qr-input').value;
    
    if (!qrInput) {
        showAlert('Please scan or enter QR code', 'error');
        return;
    }
    
    showAlert('Verifying QR code...', 'info');
    
    setTimeout(() => {
        const isValid = Math.random() > 0.2; // 80% success rate for demo
        const resultDiv = document.getElementById('verification-result');
        const contentDiv = document.getElementById('result-content');
        
        resultDiv.classList.remove('hidden');
        
        if (isValid) {
            contentDiv.innerHTML = `
                <div class="alert alert-success">
                    <h3 style="margin-bottom: 0.5rem;">✓ QR Code Verified!</h3>
                    <p>Transaction ID: ${qrInput}</p>
                    <p>Status: Valid</p>
                    <p>Gate will open automatically...</p>
                </div>
            `;
            
            setTimeout(() => {
                openGate();
            }, 2000);
        } else {
            contentDiv.innerHTML = `
                <div class="alert alert-error">
                    <h3 style="margin-bottom: 0.5rem;">✗ Verification Failed</h3>
                    <p>This QR code is invalid or has expired.</p>
                    <p>Please check the QR code and try again.</p>
                </div>
            `;
        }
    }, 1500);
}

function openGate() {
    const contentDiv = document.getElementById('result-content');
    contentDiv.innerHTML = `
        <div class="alert alert-success">
            <h3 style="margin-bottom: 0.5rem;">🚦 Gate Opened!</h3>
            <p>Vehicle can proceed through the toll gate.</p>
            <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-gray);">Gate will close automatically after vehicle passes.</p>
        </div>
    `;
    
    // Reset form after 5 seconds
    setTimeout(() => {
        document.getElementById('qr-input').value = '';
        document.getElementById('verification-result').classList.add('hidden');
    }, 5000);
}
</script>
@endsection

