@extends('layouts.app')

@section('title', 'E-Toll - Government services at one address')

@section('content')
<div class="hero-section">
    <h1 class="hero-title">Government services at one address</h1>
    
    <div class="search-container">
        <input type="text" id="search-input" class="search-input" placeholder="Search for services">
        <button class="search-btn" onclick="searchServices()">Search</button>
    </div>
</div>

<div class="card">
    <h2 class="card-title">Quick Services</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <a href="/route-selection" style="text-decoration: none;">
            <div class="payment-method">
                <div class="payment-icon">🛣️</div>
                <div class="payment-name">Pay Toll</div>
            </div>
        </a>
        <a href="/my-tickets" style="text-decoration: none;">
            <div class="payment-method">
                <div class="payment-icon">🎫</div>
                <div class="payment-name">My Tickets</div>
            </div>
        </a>
        <a href="/history" style="text-decoration: none;">
            <div class="payment-method">
                <div class="payment-icon">📜</div>
                <div class="payment-name">Payment History</div>
            </div>
        </a>
        <a href="/help" style="text-decoration: none;">
            <div class="payment-method">
                <div class="payment-icon">❓</div>
                <div class="payment-name">Help & Support</div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <h2 class="card-title">How It Works</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
        <div style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">1️⃣</div>
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">Select Route</h3>
            <p style="color: var(--text-gray);">Choose your origin and destination</p>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">2️⃣</div>
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">Make Payment</h3>
            <p style="color: var(--text-gray);">Pay using Bkash, Nagad, Rocket, or Card</p>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">3️⃣</div>
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">Get QR Code</h3>
            <p style="color: var(--text-gray);">Receive your digital QR code</p>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">4️⃣</div>
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">Scan & Go</h3>
            <p style="color: var(--text-gray);">Scan at toll gate and pass through</p>
        </div>
    </div>
</div>
@endsection

