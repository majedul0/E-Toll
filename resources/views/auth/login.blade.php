@extends('layouts.app')

@section('title', 'Login - E-Toll')

@section('content')
<!---- Login Functionality--- -->
<div style="max-width: 500px; margin: 3rem auto;">
    <div class="card">
        <h2 class="card-title">Citizen Login</h2>
        
        @if ($errors->any())
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 1rem; margin-bottom: 1.5rem; color: #721c24;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 0.5rem 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="identifier">Phone Number or Email</label>
                <input
                    type="text"
                    id="identifier"
                    name="identifier"
                    class="form-input"
                    value="{{ old('identifier') }}"
                    placeholder="Enter phone or email"
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
                    placeholder="Enter password"
                    required
                >
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-gray);">Don't have an account? <a href="/register" style="color: var(--primary-green);">Register here</a></p>
        </div>
    </div>
</div>
@endsection

