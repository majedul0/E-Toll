<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'E-Toll - Bangladesh Government')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png?v=' . time()) }}" sizes="any">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png?v=' . time()) }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png?v=' . time()) }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/etoll.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Bangladesh Emblem" class="logo" style="width: 64px; height: 64px; object-fit: contain;">
                <div class="logo-text">
                    <h1 data-i18n="title">E-Toll</h1>
                    <span class="subtitle" data-i18n="subtitle">সরকারি সেবা এক ঠিকানায়</span>
                </div>
            </div>
            
            <div class="header-actions">
                <div class="lang-selector">
                    <button class="lang-btn active" data-lang="eng" onclick="toggleLanguage('eng', this)">ENG</button>
                    <button class="lang-btn" data-lang="beng" onclick="toggleLanguage('beng', this)">বাংলা</button>
                </div>
                
                <a href="/help" class="help-desk-btn">
                    <span>📞</span>
                    <span data-i18n="help_desk">Help Desk</span>
                </a>
                
                @auth
                    <div class="auth-buttons">
                        <a href="/dashboard" class="btn" data-i18n="dashboard">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary" data-i18n="logout">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="/login" class="btn" data-i18n="citizen_login">Citizen Login</a>
                        <a href="/official-login" class="btn" data-i18n="official_login">Official Login</a>
                        <a href="/register" class="btn btn-primary" data-i18n="registration">Registration</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0 0 0 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} E-Toll System - Bangladesh Government. All rights reserved.</p>
    </footer>
    
    <!-- JavaScript -->
    <script src="{{ asset('js/etoll.js') }}"></script>
    
    @stack('scripts')
</body>
</html>

