@extends('layouts.app')

@section('title', 'Payment - E-Toll')

@section('content')
<div style="max-width: 800px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">Payment</h2>
        
        <div style="background: var(--light-green); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Route</p>
                    <p style="font-weight: 600;" id="payment-route">-</p>
                </div>
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Amount</p>
                    <p style="font-weight: 600; color: var(--primary-green); font-size: 1.2rem;" id="payment-amount">-</p>
                </div>
            </div>
        </div>
        
        <h3 style="color: var(--primary-green); margin-bottom: 1.5rem;">Select Payment Method</h3>
        
        <input type="hidden" id="selected-payment" value="">
        
        <div class="payment-methods">
            <div class="payment-method" onclick="selectPaymentMethod('bkash')">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Bkash</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('nagad')">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Nagad</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('rocket')">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Rocket</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('card')">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Card</div>
            </div>
        </div>
        
        <div id="payment-details" class="hidden" style="margin-top: 2rem;">
            <div class="form-group">
                <label class="form-label">Account Number / Card Number</label>
                <input type="text" id="account-number" class="form-input" placeholder="Enter account/card number" required>
            </div>
            
            <div class="form-group" id="pin-group" style="display: none;">
                <label class="form-label">PIN</label>
                <input type="password" id="pin" class="form-input" placeholder="Enter PIN" maxlength="4">
            </div>
            
            <div class="form-group" id="card-details" style="display: none;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label class="form-label">Expiry Date</label>
                        <input type="text" id="expiry" class="form-input" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div>
                        <label class="form-label">CVV</label>
                        <input type="password" id="cvv" class="form-input" placeholder="CVV" maxlength="3">
                    </div>
                </div>
            </div>
            
            <button class="btn btn-primary" onclick="processPayment()" style="width: 100%;">Pay Now</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load route info from sessionStorage
    const origin = sessionStorage.getItem('routeOrigin');
    const destination = sessionStorage.getItem('routeDestination');
    const amount = sessionStorage.getItem('tollAmount');
    
    if (origin && destination) {
        document.getElementById('payment-route').textContent = `${origin} → ${destination}`;
    }
    
    if (amount) {
        document.getElementById('payment-amount').textContent = amount;
    }
});

function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    document.getElementById('selected-payment').value = method;
    
    // Show payment details
    document.getElementById('payment-details').classList.remove('hidden');
    
    // Show/hide relevant fields
    const pinGroup = document.getElementById('pin-group');
    const cardDetails = document.getElementById('card-details');
    
    if (method === 'bkash' || method === 'nagad' || method === 'rocket') {
        pinGroup.style.display = 'block';
        cardDetails.style.display = 'none';
    } else if (method === 'card') {
        pinGroup.style.display = 'none';
        cardDetails.style.display = 'block';
    }
}

function processPayment() {
    const paymentMethod = document.getElementById('selected-payment').value;
    
    if (!paymentMethod) {
        showAlert('Please select a payment method', 'error');
        return;
    }
    
    const accountNumber = document.getElementById('account-number').value;
    if (!accountNumber) {
        showAlert('Please enter account/card number', 'error');
        return;
    }
    
    // Simulate payment processing
    showAlert('Processing payment...', 'info');
    
    setTimeout(() => {
        const transactionId = 'TXN' + Date.now();
        sessionStorage.setItem('transactionId', transactionId);
        showAlert('Payment successful!', 'success');
        setTimeout(() => {
            window.location.href = `/qr-code?txn=${transactionId}`;
        }, 1000);
    }, 2000);
}
</script>
@endsection

