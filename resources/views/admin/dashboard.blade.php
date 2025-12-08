@extends('layouts.app')

@section('title', 'Admin Dashboard - E-Toll')

@section('content')
<h1 style="color: var(--primary-green); margin-bottom: 2rem;">Admin Dashboard</h1>

<!-- Cards -->
<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>Total Transactions</h3>
        <div class="value">1,234</div>
        <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.5rem;">+12% from last month</p>
    </div>
    
    <div class="dashboard-card">
        <h3>Total Revenue</h3>
        <div class="value">৳5,67,890</div>
        <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.5rem;">Today: ৳12,345</p>
    </div>
    
    <div class="dashboard-card">
        <h3>Active Users</h3>
        <div class="value">8,901</div>
        <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.5rem;">+5% from last week</p>
    </div>
    
    <div class="dashboard-card">
        <h3>Routes</h3>
        <div class="value">24</div>
        <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 0.5rem;">Active routes</p>
    </div>
</div>

<!-- Manage Toll Routes -->
<div class="card">
    <h2 class="card-title">Manage Toll Routes</h2>
    
    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-green); margin-bottom: 1rem;">Add New Route</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Origin</label>
                <input type="text" id="admin-origin" class="form-input" placeholder="Enter origin">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Destination</label>
                <input type="text" id="admin-destination" class="form-input" placeholder="Enter destination">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Toll Amount (৳)</label>
                <input type="number" id="admin-amount" class="form-input" placeholder="Amount">
            </div>
            <button class="btn btn-primary" onclick="addTollRoute()">Add Route</button>
        </div>
    </div>
    
    <div class="table-container">
        <table id="routes-table">
            <thead>
                <tr>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Toll Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dhaka</td>
                    <td>Chittagong</td>
                    <td>৳500</td>
                    <td>
                        <button onclick="editRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">Edit</button>
                        <button onclick="deleteRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem; background: var(--error-red); color: white; border: none;">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Dhaka</td>
                    <td>Sylhet</td>
                    <td>৳400</td>
                    <td>
                        <button onclick="editRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">Edit</button>
                        <button onclick="deleteRoute(this)" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem; background: var(--error-red); color: white; border: none;">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <h2 class="card-title">Recent Transactions</h2>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>User</th>
                    <th>Route</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TXN123456</td>
                    <td>saif@example.com</td>
                    <td>Dhaka → Chittagong</td>
                    <td>৳500</td>
                    <td>Bkash</td>
                    <td>2024-01-15 10:30</td>
                    <td><span style="color: var(--success-green);">✓ Completed</span></td>
                </tr>
                <tr>
                    <td>TXN123455</td>
                    <td>user2@example.com</td>
                    <td>Dhaka → Sylhet</td>
                    <td>৳400</td>
                    <td>Nagad</td>
                    <td>2024-01-15 09:15</td>
                    <td><span style="color: var(--success-green);">✓ Completed</span></td>
                </tr>
                <tr>
                    <td>TXN123454</td>
                    <td>user3@example.com</td>
                    <td>Chittagong → Sylhet</td>
                    <td>৳600</td>
                    <td>Card</td>
                    <td>2024-01-15 08:45</td>
                    <td><span style="color: var(--success-green);">✓ Completed</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- User Management -->
<div class="card">
    <h2 class="card-title">User Management</h2>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Transactions</th>
                    <th>Total Spent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jeon</td>
                    <td>jeon@gmail.com</td>
                    <td>01712345678</td>
                    <td>15</td>
                    <td>৳7,500</td>
                    <td>
                        <button class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">View</button>
                    </td>
                </tr>
                <tr>
                    <td>Sahik</td>
                    <td>sahik@gmail.com</td>
                    <td>01812345678</td>
                    <td>8</td>
                    <td>৳3,200</td>
                    <td>
                        <button class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

