# E-Toll System - Frontend Documentation

## Overview
This document describes the frontend implementation of the E-Toll system for Bangladesh Government. The frontend is built using HTML, CSS, and JavaScript (DOM manipulation) following the Bangladesh government theme with green color scheme.

## File Structure

### CSS Files
- `public/css/etoll.css` - Main stylesheet with Bangladesh government theme (green colors, clean design)

### JavaScript Files
- `public/js/etoll.js` - Main JavaScript file with DOM manipulation for all interactive features

### Blade Templates (Views)
- `resources/views/layouts/app.blade.php` - Main layout template with header, logo, and navigation
- `resources/views/home.blade.php` - Homepage with search functionality
- `resources/views/auth/login.blade.php` - Citizen login page
- `resources/views/auth/register.blade.php` - User registration with OTP verification
- `resources/views/route-selection.blade.php` - Route selection with toll calculation
- `resources/views/payment.blade.php` - Payment page with Bkash, Nagad, Rocket, and Card options
- `resources/views/qr-code.blade.php` - QR code generation and display
- `resources/views/qr-verification.blade.php` - QR verification for toll booth operators
- `resources/views/admin/dashboard.blade.php` - Admin dashboard with toll routes, rates, users, and reports
- `resources/views/dashboard.blade.php` - User dashboard
- `resources/views/help.blade.php` - Help and support page

### Routes
- `routes/web.php` - All frontend routes defined

## Features Implemented

### 1. User Registration and Login
- Phone/Email registration with OTP verification
- Secure login system
- OTP input with auto-focus functionality

### 2. Route Selection
- Origin and destination selection
- Toll amount calculation
- Route map display (placeholder for integration)
- Distance calculation

### 3. Payment Module
- Integration with local gateways:
  - Bkash
  - Nagad
  - Rocket
  - Credit/Debit Cards
- Digital invoice generation
- Payment processing simulation

### 4. QR Code Generation
- Unique QR code generation after payment
- Transaction ID display
- Download and print functionality
- QR code validity information

### 5. QR Verification at Toll Booth
- QR code scanning/input
- Payment verification
- Automatic gate opening simulation
- Status feedback

### 6. Admin Dashboard
- Toll route management (add, edit, delete)
- User management
- Transaction reports
- Revenue statistics
- Real-time data display

## Design Theme

### Color Scheme
- Primary Green: `#006A4E` (Bangladesh flag green)
- Secondary Green: `#00A86B`
- Light Green: `#E8F5E9`
- Dark Green: `#004D3A`
- Background: White to light green gradient
- Text: Dark gray (`#1B1B18`)

### Logo
- Features Bangladesh map with national emblem
- Green circle with yellow/gold map shape
- Stars representing national flag elements

## Key JavaScript Functions

### Authentication
- `sendOTP()` - Sends OTP to user's phone/email
- `verifyOTP()` - Verifies entered OTP
- `handleLogin()` - Processes user login
- `handleRegistration()` - Processes user registration

### Route & Payment
- `selectRoute()` - Calculates toll for selected route
- `calculateToll()` - Mock toll calculation
- `selectPaymentMethod()` - Handles payment method selection
- `processPayment()` - Processes payment and generates QR code

### QR Code
- `displayQRCode()` - Displays generated QR code
- `verifyQR()` - Verifies QR code at toll booth
- `openGate()` - Simulates gate opening

### Admin
- `addTollRoute()` - Adds new toll route
- `editRoute()` - Edits existing route
- `deleteRoute()` - Deletes route

### Utilities
- `showAlert()` - Displays alert messages
- `validateForm()` - Validates form inputs
- `toggleLanguage()` - Language switching (Bengali/English)

## Responsive Design
- Mobile-friendly layout
- Responsive grid system
- Adaptive navigation
- Touch-friendly buttons

## Browser Compatibility
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers support
- Progressive enhancement approach

## Next Steps for Backend Integration

1. **API Integration**
   - Connect frontend forms to Laravel controllers
   - Implement actual OTP sending via SMS/Email
   - Integrate payment gateway APIs (Bkash, Nagad, Rocket)

2. **Database Integration**
   - User authentication with Laravel Auth
   - Store transactions in database
   - Route and toll data management

3. **QR Code Library**
   - Integrate QR code generation library (e.g., qrcode.js)
   - Generate actual scannable QR codes
   - Store QR codes in database

4. **Map Integration**
   - Integrate Google Maps or similar service
   - Display actual route visualization
   - Calculate real distances

5. **Real-time Features**
   - WebSocket for gate status updates
   - Real-time transaction notifications
   - Live dashboard updates

## Usage

1. Start Laravel development server:
   ```bash
   php artisan serve
   ```

2. Access the application:
   - Homepage: `http://localhost:8000/`
   - Login: `http://localhost:8000/login`
   - Register: `http://localhost:8000/register`
   - Route Selection: `http://localhost:8000/route-selection`
   - Admin Dashboard: `http://localhost:8000/admin/dashboard`

## Notes

- All payment processing is currently simulated
- QR codes are displayed as placeholders (integrate QR library for production)
- Map visualization is a placeholder (integrate mapping service)
- OTP verification is simulated (integrate SMS/Email service)
- All data is currently client-side (connect to backend APIs)

## License
Bangladesh Government - E-Toll System

