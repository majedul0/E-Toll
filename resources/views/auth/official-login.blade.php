@extends('layouts.app')

@section('title', 'Official Login - E-Toll')

@section('content')
<div style="max-width: 500px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">Official Portal Login</h2>
        <p style="color: var(--text-gray); margin-bottom: 1.5rem;">Use your authorized account to manage toll operations.</p>
        
        <form id="official-login-form" method="POST" action="{{ route('official.login.submit') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="official-identifier">Official Email or Phone</label>
                <input
                    type="text"
                    id="official-identifier"
                    name="identifier"
                    class="form-input"
                    value="{{ old('identifier') }}"
                    placeholder="Enter official email or phone"
                    required
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="official-password">Password</label>
                <input
                    type="password"
                    id="official-password"
                    name="password"
                    class="form-input"
                    placeholder="Enter password"
                    required
                >
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login to Portal</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-gray);">Need citizen access? <a href="/login" style="color: var(--primary-green);">Go to citizen login</a></p>
        </div>
    </div>
</div>
@endsection

