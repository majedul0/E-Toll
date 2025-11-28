@extends('layouts.app')

@section('title', 'Select Route - E-Toll')

@section('content')
<div class="card">
    <h2 class="card-title">Select Your Route</h2>
    
    <div class="route-container">
        <div>
            <div class="form-group">
                <label class="form-label">Origin</label>
                <select id="origin" class="form-select">
                    <option value="">Select origin</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Barisal">Barisal</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Destination</label>
                <select id="destination" class="form-select">
                    <option value="">Select destination</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Barisal">Barisal</option>
                </select>
            </div>
            
            <button class="btn btn-primary" onclick="selectRoute()" style="width: 100%; margin-top: 1rem;">Calculate Toll</button>
        </div>
        
        <div id="map-container" class="map-container">
            <p>Select origin and destination to view route map</p>
        </div>
    </div>
    
    <div id="route-details-section" class="hidden">
        <div class="route-details">
            <h3 style="color: var(--primary-green); margin-bottom: 1rem;">Route Information</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Origin</p>
                    <p style="font-weight: 600;" id="display-origin">-</p>
                </div>
                <div>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Destination</p>
                    <p style="font-weight: 600;" id="display-destination">-</p>
                </div>
            </div>
            
            <div class="toll-info">
                <p style="color: var(--text-gray); font-size: 0.9rem;">Total Toll Amount</p>
                <div class="toll-amount" id="toll-amount">৳0</div>
                <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.5rem;">Distance: <span id="distance">-</span> km</p>
            </div>
            
            <button class="btn btn-primary" onclick="proceedToPayment()" style="width: 100%; margin-top: 1.5rem;">Proceed to Payment</button>
        </div>
    </div>
</div>

<script>
function proceedToPayment() {
    const origin = document.getElementById('origin').value;
    const destination = document.getElementById('destination').value;
    const amount = document.getElementById('toll-amount').textContent;
    
    if (!origin || !destination) {
        showAlert('Please select route first', 'error');
        return;
    }
    
    // Store route info in sessionStorage
    sessionStorage.setItem('routeOrigin', origin);
    sessionStorage.setItem('routeDestination', destination);
    sessionStorage.setItem('tollAmount', amount);
    
    window.location.href = '/payment';
}

function selectRoute() {
    const origin = document.getElementById('origin').value;
    const destination = document.getElementById('destination').value;
    
    if (!origin || !destination) {
        showAlert('Please select both origin and destination', 'error');
        return;
    }
    
    if (origin === destination) {
        showAlert('Origin and destination cannot be the same', 'error');
        return;
    }
    
    // Update display
    document.getElementById('display-origin').textContent = origin;
    document.getElementById('display-destination').textContent = destination;
    
    // Calculate toll
    const tollAmount = calculateToll(origin, destination);
    document.getElementById('toll-amount').textContent = '৳' + tollAmount;
    
    // Mock distance
    const distance = Math.floor(Math.random() * 200) + 100;
    document.getElementById('distance').textContent = distance;
    
    // Show route details
    document.getElementById('route-details-section').classList.remove('hidden');
    
    // Update map
    updateMap(origin, destination);
}
</script>
@endsection

