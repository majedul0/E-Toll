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
        
        // Load route info
        const origin = sessionStorage.getItem('routeOrigin');
        const destination = sessionStorage.getItem('routeDestination');
        const amount = sessionStorage.getItem('tollAmount');
        
        if (origin && destination) {
            document.getElementById('qr-route').textContent = `${origin} → ${destination}`;
        }
        
        if (amount) {
            document.getElementById('qr-amount').textContent = amount;
        }
        
        displayQRCode({
            txnId,
            origin,
            destination,
            amount
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

    const payload = JSON.stringify({
        txn: txnId,
        route: origin && destination ? `${origin} -> ${destination}` : null,
        amount: amount || null,
        ts: Date.now()
    });

    qrContainer.innerHTML = '';

    if (typeof QRCode === 'undefined') {
        qrContainer.innerHTML = `<p style="padding:1rem;">QR library not loaded.</p>`;
        return;
    }

    new QRCode(qrContainer, {
        text: payload,
        width: 240,
        height: 240,
        colorDark: "#0f5132",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
}

function downloadQR() {
    showAlert('QR Code download initiated', 'success');
    // Implement actual download functionality
}

function printQR() {
    window.print();
}
</script>
@endsection

