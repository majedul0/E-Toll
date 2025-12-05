@extends('layouts.app')

@section('title', 'QR Code - E-Toll')

@section('content')
@push('scripts')
<script src="{{ asset('vendor/qrcodejs/qrcode.min.js') }}"></script>
@endpush

<div style="max-width: 600px; margin: 3rem auto;">
    <div class="qr-container">
        <h2 class="card-title">Your QR Code</h2>
        <p style="color: var(--text-gray); margin-bottom: 2rem;">Scan this QR code at the toll gate</p>
        
        <div id="qr-code" class="qr-code">
            <div class="spinner"></div>
        </div>
        
        <div style="margin-top: 2rem; padding: 1.5rem; background: var(--light-green); border-radius: 10px;">
            <p style="color: var(--text-gray); font-size: 0.9rem; margin-bottom: 0.5rem;">Transaction ID</p>
            <p style="font-weight: 600; font-size: 1.1rem;" id="transaction-id">-</p>
            
            <div style="margin-top: 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Route</p>
                    <p style="font-weight: 600;" id="qr-route">-</p>
                </div>
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Amount</p>
                    <p style="font-weight: 600; color: var(--primary-green);" id="qr-amount">-</p>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button onclick="downloadQR()" class="btn btn-primary" style="flex: 1;">Download QR Code</button>
            <button onclick="printQR()" class="btn" style="flex: 1;">Print</button>
        </div>
        
        <div style="margin-top: 2rem; padding: 1rem; background: #FFF3CD; border-radius: 5px; border-left: 4px solid var(--warning-yellow);">
            <p style="color: #856404; font-size: 0.9rem;">
                <strong>Note:</strong> This QR code is valid for 24 hours. Please ensure your device has sufficient battery when approaching the toll gate.
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const txnId = urlParams.get('txn') || sessionStorage.getItem('transactionId');
    
    if (txnId) {
        document.getElementById('transaction-id').textContent = txnId;
        
        // Load route info from sessionStorage (if available from payment flow)
        const origin = sessionStorage.getItem('routeOrigin');
        const destination = sessionStorage.getItem('routeDestination');
        const amount = sessionStorage.getItem('tollAmount');
        
        if (origin && destination) {
            document.getElementById('qr-route').textContent = `${origin} → ${destination}`;
        }
        
        if (amount) {
            document.getElementById('qr-amount').textContent = amount;
        }
        
        // Generate QR code with transaction data
        displayQRCode({
            txnId,
            origin: origin || 'N/A',
            destination: destination || 'N/A',
            amount: amount || 'N/A'
        });
    } else {
        showAlert('No transaction found', 'error');
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
});

function displayQRCode({ txnId, origin, destination, amount }) {
    const qrContainer = document.getElementById('qr-code');

    // Create QR code payload with transaction details
    const payload = JSON.stringify({
        txn_id: txnId,
        route: origin !== 'N/A' && destination !== 'N/A' ? `${origin} → ${destination}` : null,
        amount: amount !== 'N/A' ? amount : null,
        timestamp: new Date().toISOString(),
        version: '1.0'
    });

    qrContainer.innerHTML = '';

    // Check if QRCode library is loaded
    if (typeof QRCode === 'undefined') {
        qrContainer.innerHTML = `<div style="padding:2rem; text-align:center; color:#dc3545;"><p>QR Code library not loaded. Please refresh the page.</p></div>`;
        console.error('QRCode library not found');
        return;
    }

    try {
        new QRCode(qrContainer, {
            text: payload,
            width: 280,
            height: 280,
            colorDark: "#0f5132",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        console.log('QR Code generated successfully');
    } catch (error) {
        console.error('Error generating QR code:', error);
        qrContainer.innerHTML = `<div style="padding:2rem; text-align:center; color:#dc3545;"><p>Error generating QR code. Please try again.</p></div>`;
    }
}

function downloadQR() {
    const canvas = document.querySelector('#qr-code canvas');
    if (canvas) {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'e-toll-qr-code.png';
        link.click();
        showAlert('QR Code downloaded successfully!', 'success');
    } else {
        showAlert('QR Code not found. Please refresh the page.', 'error');
    }
}

function printQR() {
    window.print();
}
</script>
@endsection

