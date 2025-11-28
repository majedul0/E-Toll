<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'E-Toll - Bangladesh Government')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/etoll.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo-container">
                <svg class="logo" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- Bangladesh Map Logo with National Emblem -->
                    <circle cx="50" cy="50" r="48" fill="#006A4E" stroke="#FFFFFF" stroke-width="2"/>
                    <!-- Simplified Bangladesh map shape -->
                    <path d="M 25 35 Q 30 25 40 30 Q 50 20 60 30 Q 70 25 75 35 Q 78 45 75 55 Q 70 70 60 65 Q 50 75 40 65 Q 30 70 25 55 Q 22 45 25 35 Z" fill="#F8B803"/>
                    <!-- National emblem - water lily and rice sheaves -->
                    <circle cx="50" cy="50" r="12" fill="#006A4E"/>
                    <circle cx="50" cy="50" r="6" fill="#F8B803"/>
                    <!-- Stars around -->
                    <circle cx="35" cy="35" r="2" fill="#FFFFFF"/>
                    <circle cx="65" cy="35" r="2" fill="#FFFFFF"/>
                    <circle cx="35" cy="65" r="2" fill="#FFFFFF"/>
                    <circle cx="65" cy="65" r="2" fill="#FFFFFF"/>
                </svg>
                <div class="logo-text">
                    <h1>E-Toll</h1>
                    <span class="subtitle">সরকারি সেবা এক ঠিকানায়</span>
                </div>
            </div>
            
            <div class="header-actions">
                <div class="lang-selector">
                    <button class="lang-btn active" onclick="toggleLanguage('eng')">ENG</button>
                    <button class="lang-btn" onclick="toggleLanguage('beng')">বাংলা</button>
                </div>
                
                <a href="/help" class="help-desk-btn">
                    <span>📞</span>
                    <span>Help Desk</span>
                </a>
                
                @auth
                    <div class="auth-buttons">
                        <a href="/dashboard" class="btn">Dashboard</a>
                        <a href="/logout" class="btn btn-primary">Logout</a>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="/login" class="btn">Citizen Login</a>
                        <a href="/official-login" class="btn">Official Login</a>
                        <a href="/register" class="btn btn-primary">Registration</a>
                    </div>
                @endauth
                
                <div class="accessibility-icon" title="Accessibility">
                    <span style="font-size: 1.5rem;">♿</span>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-container">
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

