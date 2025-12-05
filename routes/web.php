<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::view('/', 'home')->name('home');
Route::view('/help', 'help')->name('help');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/official-login', [AuthController::class, 'showOfficialLogin'])->name('official.login');
    Route::post('/official-login', [AuthController::class, 'officialLogin'])->name('official.login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated citizen features
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/route-selection', 'route-selection')->name('route-selection');
    Route::view('/payment', 'payment')->name('payment');
    Route::view('/qr-code', 'qr-code')->name('qr-code');
    Route::view('/qr-verification', 'qr-verification')->name('qr-verification');

    Route::post('/payment/session', [PaymentController::class, 'createSession'])->name('payment.session');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

// Official-only area
Route::middleware(['auth', 'official'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
});
