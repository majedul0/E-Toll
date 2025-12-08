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
        <div style="margin-bottom: 1rem; color: var(--text-gray); font-size: 0.9rem;">
            SSLCommerz sandbox: Use test credentials to complete payment. You'll receive a QR code after successful payment.
        </div>
        
        <input type="hidden" id="selected-payment" value="">
        
        <div class="payment-methods">
            <div class="payment-method" onclick="selectPaymentMethod('bkash', this)">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Bkash</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('nagad', this)">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Nagad</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('rocket', this)">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Rocket</div>
            </div>
            <div class="payment-method" onclick="selectPaymentMethod('card', this)">
                <div class="payment-icon">💳</div>
                <div class="payment-name">Visa Card</div>
            </div>
        </div>
        
        <div id="payment-details" style="margin-top: 2rem;">
            <div class="form-group">
                <label class="form-label">Account Number</label>
                <input type="text" id="account-number" class="form-input" placeholder="Enter account/card number" required>
            </div>
            
            <div class="form-group" id="pin-group" style="display: none;">
                <label class="form-label">PIN</label>
                <input type="password" id="pin" class="form-input" placeholder="Enter your pin" maxlength="4">
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
            <button class="btn" onclick="processPayment()" style="width: 100%; margin-top: 0.75rem; background: var(--border-color); color: var(--text-dark);">Continue</button>
        </div>
    </div>
</div>

<script>
function initPaymentPage() {
    
    const origin = sessionStorage.getItem('routeOrigin');
    const destination = sessionStorage.getItem('routeDestination');
    const amount = sessionStorage.getItem('tollAmount');
    
    if (origin && destination) {
        document.getElementById('payment-route').textContent = `${origin} → ${destination}`;
    }
    
    if (amount) {
        document.getElementById('payment-amount').textContent = amount;
    }

    
    const firstMethod = document.querySelector('.payment-method');
    if (firstMethod) {
        selectPaymentMethod(firstMethod.querySelector('.payment-name').textContent.toLowerCase(), firstMethod);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPaymentPage);
} else {
    initPaymentPage();
}

function selectPaymentMethod(method, el) {
    document.querySelectorAll('.payment-method').forEach(btn => {
        btn.classList.remove('selected');
    });
    if (el) {
        el.classList.add('selected');
    }
    document.getElementById('selected-payment').value = method;
    
    
    const paymentDetails = document.getElementById('payment-details');
    if (paymentDetails) {
        paymentDetails.classList.remove('hidden');
        paymentDetails.style.display = 'block';
    }
    
    
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
    
    const spinnerText = `Connecting to SSL Commerz (${paymentMethod.toUpperCase()})...`;
    showAlert(spinnerText, 'info');
    
    
    const origin = sessionStorage.getItem('routeOrigin');
    const destination = sessionStorage.getItem('routeDestination');
    const amount = sessionStorage.getItem('tollAmount');
    
    fetch('/payment/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            amount: amount || 100,
            method: paymentMethod,
            origin: origin,
            destination: destination
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'SUCCESS' && data.gateway_url) {
            
            sessionStorage.setItem('transactionId', data.tran_id);
            sessionStorage.setItem('paymentMethod', paymentMethod);
            showAlert('Redirecting to payment gateway...', 'success');
            
            setTimeout(() => {
                window.location.href = data.gateway_url;
            }, 500);
        } else {
            showAlert(`Payment error: ${data.failedreason || 'Unknown error'}`, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Payment gateway error. Please try again.', 'error');
    });
}
</script>
@endsection

