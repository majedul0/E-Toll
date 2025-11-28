@extends('layouts.app')

@section('title', 'Dashboard - E-Toll')

@section('content')
<h1 style="color: var(--primary-green); margin-bottom: 2rem;">My Dashboard</h1>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>Total Trips</h3>
        <div class="value">12</div>
    </div>
    
    <div class="dashboard-card">
        <h3>Total Spent</h3>
        <div class="value">৳6,000</div>
    </div>
    
    <div class="dashboard-card">
        <h3>Active Tickets</h3>
        <div class="value">2</div>
    </div>
</div>

<div class="card">
    <h2 class="card-title">Recent Transactions</h2>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Route</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TXN123456</td>
                    <td>Dhaka → Chittagong</td>
                    <td>৳500</td>
                    <td>2024-01-15 10:30</td>
                    <td><span style="color: var(--success-green);">✓ Active</span></td>
                    <td><a href="/qr-code?txn=TXN123456" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">View QR</a></td>
                </tr>
                <tr>
                    <td>TXN123455</td>
                    <td>Dhaka → Sylhet</td>
                    <td>৳400</td>
                    <td>2024-01-14 15:20</td>
                    <td><span style="color: var(--text-gray);">Used</span></td>
                    <td><button class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 2rem;">
    <a href="/route-selection" class="btn btn-primary">Pay New Toll</a>
</div>
@endsection

