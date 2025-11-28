@extends('layouts.app')

@section('title', 'Help & Support - E-Toll')

@section('content')
<div style="max-width: 800px; margin: 3rem auto;">
    <h1 style="color: var(--primary-green); margin-bottom: 2rem;">Help & Support</h1>
    
    <div class="card">
        <h2 class="card-title">Frequently Asked Questions</h2>
        
        <div style="margin-top: 2rem;">
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">How do I pay toll online?</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                Select your route, choose a payment method (Bkash, Nagad, Rocket, or Card), complete the payment, and receive your QR code.
            </p>
            
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">How long is the QR code valid?</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                QR codes are valid for 24 hours from the time of purchase.
            </p>
            
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">What payment methods are accepted?</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                We accept Bkash, Nagad, Rocket, and all major credit/debit cards.
            </p>
            
            <h3 style="color: var(--primary-green); margin-bottom: 0.5rem;">What if my QR code doesn't work?</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                Contact our help desk immediately. We can verify your transaction and provide assistance.
            </p>
        </div>
    </div>
    
    <div class="card" style="margin-top: 2rem;">
        <h2 class="card-title">Contact Us</h2>
        
        <div style="margin-top: 2rem;">
            <p style="margin-bottom: 1rem;"><strong>Phone:</strong> 16500</p>
            <p style="margin-bottom: 1rem;"><strong>Email:</strong> support@etoll.gov.bd</p>
            <p style="margin-bottom: 1rem;"><strong>Office Hours:</strong> 9:00 AM - 5:00 PM (Saturday - Thursday)</p>
        </div>
    </div>
</div>
@endsection

