// E-Toll System - Main JavaScript File

// Language Toggle
const translations = {
    eng: {
        help_desk: 'Help Desk',
        dashboard: 'Dashboard',
        logout: 'Logout',
        citizen_login: 'Citizen Login',
        official_login: 'Official Login',
        registration: 'Registration',
        subtitle: 'সরকারি সেবা এক ঠিকানায়',
        title: 'E-Toll',
    },
    beng: {
        help_desk: 'হেল্প ডেস্ক',
        dashboard: 'ড্যাশবোর্ড',
        logout: 'লগআউট',
        citizen_login: 'নাগরিক লগইন',
        official_login: 'অফিসিয়াল লগইন',
        registration: 'নিবন্ধন',
        subtitle: 'সরকারি সেবা এক ঠিকানায়',
        title: 'ই-টোল',
    },
};

function applyTranslations(lang) {
    const dict = translations[lang] || translations.eng;
    document.documentElement.lang = lang === 'beng' ? 'bn' : 'en';

    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.dataset.i18n;
        if (dict[key]) {
            el.textContent = dict[key];
        }
    });
}

function toggleLanguage(lang, btnEl) {
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    if (btnEl) {
        btnEl.classList.add('active');
    }
    localStorage.setItem('etoll_lang', lang);
    applyTranslations(lang);
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
    if (!mapContainer) return;

    if (typeof L === 'undefined') {
        mapContainer.innerHTML = `
            <div style="text-align: center; padding: 2rem;">
                <p style="color: var(--text-gray);">Map library not loaded. Please check your internet connection.</p>
            </div>
        `;
        return;
    }

    if (!window.routeMap) {
        window.routeMap = L.map('map-container').setView([23.777, 90.399], 6.5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(window.routeMap);
    }

    const coords = {
        Dhaka: [23.777, 90.399],
        Chittagong: [22.347, 91.812],
        Sylhet: [24.8949, 91.8687],
        Rajshahi: [24.3745, 88.6042],
        Khulna: [22.8456, 89.5403],
        Barisal: [22.7010, 90.3535],
    };

    const originCoord = coords[origin];
    const destCoord = coords[destination];

    if (!originCoord || !destCoord) {
        mapContainer.innerHTML = `<p style="padding:1rem;">Coordinates not found for the selected cities.</p>`;
        return;
    }

    // Clear previous layers
    if (window.routeLayer) {
        window.routeMap.removeLayer(window.routeLayer);
    }
    if (window.routeMarkers) {
        window.routeMarkers.forEach(m => window.routeMap.removeLayer(m));
    }

    const points = [originCoord, destCoord];
    window.routeMarkers = [
        L.marker(originCoord).bindPopup(`Origin: ${origin}`),
        L.marker(destCoord).bindPopup(`Destination: ${destination}`)
    ];
    window.routeMarkers.forEach(m => m.addTo(window.routeMap));

    window.routeLayer = L.polyline(points, { color: '#0f9d58', weight: 5, opacity: 0.8 }).addTo(window.routeMap);
    window.routeMap.fitBounds(window.routeLayer.getBounds(), { padding: [40, 40] });
}

// Payment Method Selection
function selectPaymentMethod(method, el) {
    document.querySelectorAll('.payment-method').forEach(btn => {
        btn.classList.remove('selected');
    });
    if (el) {
        el.classList.add('selected');
    }
    const selectedField = document.getElementById('selected-payment');
    if (selectedField) {
        selectedField.value = method;
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

    const amountText = sessionStorage.getItem('tollAmount') || '';
    const amount = parseFloat(amountText.toString().replace(/[^\d.]/g, '')) || 0;
    const origin = sessionStorage.getItem('routeOrigin') || '';
    const destination = sessionStorage.getItem('routeDestination') || '';

    if (!amount) {
        showAlert('Missing amount. Please reselect the route.', 'error');
        return;
    }

    showAlert(`Connecting to SSL sandbox (${paymentMethod.toUpperCase()})...`, 'info');

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/payment/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf || ''
        },
        body: JSON.stringify({
            amount,
            method: paymentMethod,
            origin,
            destination,
            account: accountNumber
        })
    })
    .then(res => res.json().then(data => ({ ok: res.ok, data })))
    .then(({ ok, data }) => {
        if (!ok || data.status !== 'SUCCESS') {
            const reason = data.failedreason || 'Payment session failed';
            showAlert(reason, 'error');
            return;
        }
        if (data.gateway_url) {
            sessionStorage.setItem('transactionId', data.tran_id || '');
            window.location.href = data.gateway_url;
        } else {
            showAlert('Gateway URL missing in response', 'error');
        }
    })
    .catch(() => {
        showAlert('Network error while creating payment session', 'error');
    });
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
    // Apply saved language preference
    const savedLang = localStorage.getItem('etoll_lang') || 'eng';
    const activeBtn = document.querySelector(`.lang-btn[data-lang="${savedLang}"]`);
    if (activeBtn) {
        toggleLanguage(savedLang, activeBtn);
    } else {
        applyTranslations(savedLang);
    }

    window.calculateDistanceKm = function (from, to) {
        const coords = {
            Dhaka: [23.777, 90.399],
            Chittagong: [22.347, 91.812],
            Sylhet: [24.8949, 91.8687],
            Rajshahi: [24.3745, 88.6042],
            Khulna: [22.8456, 89.5403],
            Barisal: [22.7010, 90.3535],
        };
        const a = coords[from];
        const b = coords[to];
        if (!a || !b) return '-';
        const R = 6371;
        const toRad = d => d * Math.PI / 180;
        const dLat = toRad(b[0] - a[0]);
        const dLon = toRad(b[1] - a[1]);
        const lat1 = toRad(a[0]);
        const lat2 = toRad(b[0]);
        const h = Math.sin(dLat / 2) ** 2 + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dLon / 2) ** 2;
        const distance = 2 * R * Math.asin(Math.sqrt(h));
        return distance.toFixed(1);
    };

    // Check if QR code page
    const urlParams = new URLSearchParams(window.location.search);
    const txnId = urlParams.get('txn');
    if (txnId) {
        displayQRCode(txnId);
    }
    
    // Initialize tooltips, modals, etc.
    console.log('E-Toll System initialized');
});

