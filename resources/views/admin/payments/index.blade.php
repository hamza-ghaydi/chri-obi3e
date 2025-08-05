@extends('layouts.dashboard')

@section('title', 'Payment Management - Admin Dashboard')
@section('page-title', 'Payment Management')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>Payments</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Monitor and manage all platform payments</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn-outline">
                <i class="fas fa-cog mr-2"></i>Payment Settings
            </button>
            <button class="btn-outline">
                <i class="fas fa-download mr-2"></i>Export Report
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0 MAD</div>
                    <div class="dashboard-stat-label">Total Revenue</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0 MAD</div>
                    <div class="dashboard-stat-label">This Month</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-calendar text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0</div>
                    <div class="dashboard-stat-label">Transactions</div>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-credit-card text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">5%</div>
                    <div class="dashboard-stat-label">Commission Rate</div>
                </div>
                <div class="text-brand-beige">
                    <i class="fas fa-percentage text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Settings Card -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Payment Configuration</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Listing Fee Percentage</label>
                    <div class="flex items-center space-x-2">
                        <input type="number" value="5" min="0" max="100" step="0.1" class="form-input">
                        <span class="text-gray-600">%</span>
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Stripe Configuration</label>
                    <div class="space-y-2">
                        <input type="text" placeholder="Stripe Publishable Key" class="form-input">
                        <input type="password" placeholder="Stripe Secret Key" class="form-input">
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Payment Methods</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" checked class="mr-2">
                            <span>Credit/Debit Cards</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span>Bank Transfer</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span>PayPal</span>
                        </label>
                    </div>
                </div>
                
                <button class="btn-primary">
                    <i class="fas fa-save mr-2"></i>Save Settings
                </button>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Recent Transactions</h3>
            <div class="flex space-x-2">
                <select class="form-input text-sm">
                    <option>All Status</option>
                    <option>Completed</option>
                    <option>Pending</option>
                    <option>Failed</option>
                </select>
                <input type="date" class="form-input text-sm">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Property Owner</th>
                        <th>Property</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            <i class="fas fa-credit-card text-4xl mb-3 block"></i>
                            Payment management functionality will be implemented here
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
