@extends('layouts.app')

@section('title', 'Registration - E-Toll')

@section('content')
<div style="max-width: 600px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">User Registration</h2>
        
        <form id="register-form" method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="full-name">Full Name</label>
                <input
                    type="text"
                    id="full-name"
                    name="name"
                    class="form-input"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    class="form-input"
                    value="{{ old('phone') }}"
                    placeholder="01XXXXXXXXX"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    value="{{ old('email') }}"
                    placeholder="your.email@example.com"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="nid">NID Number</label>
                <input
                    type="text"
                    id="nid"
                    name="nid"
                    class="form-input"
                    value="{{ old('nid') }}"
                    placeholder="Enter NID number"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="Create a strong password"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="confirm-password">Confirm Password</label>
                <input
                    type="password"
                    id="confirm-password"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Confirm your password"
                    required
                >
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </form>
    </div>
</div>
@endsection

