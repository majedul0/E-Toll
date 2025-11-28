// E-Toll System - Main JavaScript File

// Language Toggle
function toggleLanguage(lang) {
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    // Here you would implement actual language switching
    console.log('Language switched to:', lang);
}

// OTP Verification
function sendOTP() {
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    
    if (!phone && !email) {
        showAlert('Please enter phone or email', 'error');
        return;
    }
    
    // Simulate OTP sending
    showAlert('OTP sent to your phone/email', 'success');
    
    // Show OTP input
    document.getElementById('otp-section').classList.remove('hidden');
}

function verifyOTP() {
    const otpInputs = document.querySelectorAll('.otp-input');
    let otp = '';
    otpInputs.forEach(input => {
        otp += input.value;
    });
    
    if (otp.length !== 6) {
        showAlert('Please enter complete OTP', 'error');
        return;
    }
    
    // Simulate OTP verification
    showAlert('OTP verified successfully!', 'success');
    setTimeout(() => {
        window.location.href = '/dashboard';
    }, 1000);
}

// OTP Input Auto-focus
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });
});

// Route Selection
function selectRoute() {
    const origin = document.getElementById('origin').value;
    const destination = document.getElementById('destination').value;
    
    if (!origin || !destination) {
        showAlert('Please select origin and destination', 'error');
        return;
    }
    
    // Calculate toll (mock calculation)
    const tollAmount = calculateToll(origin, destination);
    document.getElementById('toll-amount').textContent = '৳' + tollAmount;
    document.getElementById('route-details-section').classList.remove('hidden');
    
    // Show map (mock)
    updateMap(origin, destination);
}

function calculateToll(origin, destination) {
    // Mock toll calculation
    const routes = {
        'dhaka-chittagong': 500,
        'dhaka-sylhet': 400,
        'chittagong-sylhet': 600
    };
    
    const routeKey = origin.toLowerCase() + '-' + destination.toLowerCase();
    return routes[routeKey] || 300;
}

function updateMap(origin, destination) {
    const mapContainer = document.getElementById('map-container');
    mapContainer.innerHTML = `
        <div style="text-align: center; padding: 2rem;">
            <h3 style="color: var(--primary-green); margin-bottom: 1rem;">Route Map</h3>
            <p><strong>From:</strong> ${origin}</p>
            <p><strong>To:</strong> ${destination}</p>
            <div style="margin-top: 2rem; padding: 2rem; background: white; border-radius: 10px;">
                <p style="color: var(--text-gray);">Map visualization would appear here</p>
                <p style="color: var(--text-gray); font-size: 0.9rem;">Integration with Google Maps or similar service</p>
            </div>
        </div>
    `;
}

// Payment Method Selection
function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    document.getElementById('selected-payment').value = method;
}

function processPayment() {
    const paymentMethod = document.getElementById('selected-payment').value;
    
    if (!paymentMethod) {
        showAlert('Please select a payment method', 'error');
        return;
    }
    
    // Simulate payment processing
    showAlert('Processing payment...', 'info');
    
    setTimeout(() => {
        // Generate QR code
        const transactionId = 'TXN' + Date.now();
        generateQRCode(transactionId);
    }, 2000);
}

function generateQRCode(transactionId) {
    // Redirect to QR code page with transaction ID
    window.location.href = `/qr-code?txn=${transactionId}`;
}

// QR Code Generation (using a simple library or API)
function displayQRCode(transactionId) {
    const qrContainer = document.getElementById('qr-code');
    
    // In production, use a QR code library like qrcode.js
    // For now, showing a placeholder
    qrContainer.innerHTML = `
        <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
            <div style="width: 250px; height: 250px; background: #f0f0f0; border: 2px solid var(--primary-green); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <p style="color: var(--text-gray);">QR Code</p>
            </div>
            <p style="color: var(--text-gray); font-size: 0.9rem;">Transaction ID: ${transactionId}</p>
            <button onclick="downloadQR()" class="btn btn-primary">Download QR Code</button>
        </div>
    `;
}

function downloadQR() {
    showAlert('QR Code download initiated', 'success');
    // Implement actual download functionality
}

// QR Verification (for toll booth operators)
function verifyQR() {
    const qrInput = document.getElementById('qr-input').value;
    
    if (!qrInput) {
        showAlert('Please scan or enter QR code', 'error');
        return;
    }
    
    // Simulate verification
    showAlert('Verifying QR code...', 'info');
    
    setTimeout(() => {
        const isValid = Math.random() > 0.2; // 80% success rate for demo
        
        if (isValid) {
            showAlert('QR Code verified! Gate opening...', 'success');
            openGate();
        } else {
            showAlert('Invalid or expired QR code', 'error');
        }
    }, 1500);
}

function openGate() {
    showAlert('Gate opened successfully!', 'success');
    // Reset form
    document.getElementById('qr-input').value = '';
}

// Admin Functions
function addTollRoute() {
    const origin = document.getElementById('admin-origin').value;
    const destination = document.getElementById('admin-destination').value;
    const amount = document.getElementById('admin-amount').value;
    
    if (!origin || !destination || !amount) {
        showAlert('Please fill all fields', 'error');
        return;
    }
    
    // Add to table
    const table = document.getElementById('routes-table').getElementsByTagName('tbody')[0];
    const row = table.insertRow();
    row.innerHTML = `
        <td>${origin}</td>
        <td>${destination}</td>
        <td>৳${amount}</td>
        <td>
            <button onclick="editRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">Edit</button>
            <button onclick="deleteRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem; background: var(--error-red); color: white; border: none;">Delete</button>
        </td>
    `;
    
    showAlert('Route added successfully', 'success');
    // Reset form
    document.getElementById('admin-origin').value = '';
    document.getElementById('admin-destination').value = '';
    document.getElementById('admin-amount').value = '';
}

function deleteRoute(btn) {
    if (confirm('Are you sure you want to delete this route?')) {
        btn.closest('tr').remove();
        showAlert('Route deleted successfully', 'success');
    }
}

function editRoute(btn) {
    const row = btn.closest('tr');
    const cells = row.getElementsByTagName('td');
    
    document.getElementById('admin-origin').value = cells[0].textContent;
    document.getElementById('admin-destination').value = cells[1].textContent;
    document.getElementById('admin-amount').value = cells[2].textContent.replace('৳', '');
    
    row.remove();
    showAlert('Route loaded for editing', 'info');
}

// Alert System
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.main-container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Search Functionality
function searchServices() {
    const query = document.getElementById('search-input').value;
    
    if (!query) {
        showAlert('Please enter a search term', 'error');
        return;
    }
    
    // Simulate search
    showAlert(`Searching for: ${query}`, 'info');
    // In production, this would make an API call
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'var(--error-red)';
            isValid = false;
        } else {
            input.style.borderColor = 'var(--border-color)';
        }
    });
    
    return isValid;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if QR code page
    const urlParams = new URLSearchParams(window.location.search);
    const txnId = urlParams.get('txn');
    if (txnId) {
        displayQRCode(txnId);
    }
    
    // Initialize tooltips, modals, etc.
    console.log('E-Toll System initialized');
});

