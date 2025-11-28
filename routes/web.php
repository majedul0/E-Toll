<?php

use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('home');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/official-login', function () {
    return view('auth.login'); // Can be customized for official login
});

// Route Selection
Route::get('/route-selection', function () {
    return view('route-selection');
});

// Payment
Route::get('/payment', function () {
    return view('payment');
});

// QR Code
Route::get('/qr-code', function () {
    return view('qr-code');
});

// QR Verification (for toll booth operators)
Route::get('/qr-verification', function () {
    return view('qr-verification');
});

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

// Help Desk
Route::get('/help', function () {
    return view('help');
});

// Dashboard (for logged in users)
Route::get('/dashboard', function () {
    return view('dashboard');
});
