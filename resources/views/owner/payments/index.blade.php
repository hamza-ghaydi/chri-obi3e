@extends('layouts.dashboard')

@section('title', 'Payments - Owner Dashboard')
@section('page-title', 'Payment History')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>Payments</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Track your listing fees and payment history</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn-outline">
                <i class="fas fa-download mr-2"></i>Download Report
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ number_format($stats['total_paid'], 2) }} MAD</div>
                    <div class="dashboard-stat-label">Total Paid</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ number_format($stats['pending_payments'], 2) }} MAD</div>
                    <div class="dashboard-stat-label">Pending Payments</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['transactions_count'] }}</div>
                    <div class="dashboard-stat-label">Transactions</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-credit-card text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['commission_rate'] }}%</div>
                    <div class="dashboard-stat-label">Commission Rate</div>
                </div>
                <div class="text-brand-beige">
                    <i class="fas fa-percentage text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Payment Methods</h3>
            <button class="btn-primary text-sm">
                <i class="fas fa-plus mr-2"></i>Add Payment Method
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Sample Payment Method -->
            <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-8 bg-blue-600 rounded flex items-center justify-center">
                        <i class="fab fa-cc-visa text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold">•••• •••• •••• 4242</p>
                        <p class="text-sm text-gray-600">Expires 12/25</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <!-- Add New Card -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-plus text-2xl mb-2 block"></i>
                    <span class="text-sm">Add New Card</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Payment History</h3>
            <div class="flex space-x-2">
                <select class="form-input text-sm">
                    <option>All Status</option>
                    <option>Completed</option>
                    <option>Pending</option>
                    <option>Failed</option>
                </select>
                <input type="month" class="form-input text-sm">
            </div>
        </div>
        
        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Property</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <div class="font-mono text-sm">#{{ $payment->id }}</div>
                                    @if($payment->stripe_charge_id)
                                        <div class="text-xs text-gray-500">{{ Str::limit($payment->stripe_charge_id, 20) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-semibold">{{ Str::limit($payment->property->title, 30) }}</div>
                                    <div class="text-sm text-gray-600">{{ $payment->property->city->name }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ number_format($payment->amount, 2) }} MAD</div>
                                    <div class="text-xs text-gray-500">{{ $payment->fee_percentage }}% fee</div>
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $payment->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $payment->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if($payment->status === 'pending')
                                        <a href="{{ route('owner.payments.create', ['property' => $payment->property_id]) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-credit-card mr-1"></i>Pay Now
                                        </a>
                                    @elseif($payment->status === 'completed')
                                        <span class="text-green-600 text-sm">
                                            <i class="fas fa-check mr-1"></i>Paid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-receipt text-6xl text-gray-400 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Payment History</h3>
                    <p class="text-gray-500 mb-8">Your payment history will appear here once you start listing properties.</p>

                    <div class="space-y-4">
                        <a href="{{ route('owner.properties.create') }}" class="btn-primary inline-block">
                            <i class="fas fa-plus mr-2"></i>Add Your First Property
                        </a>

                        <div class="text-sm text-gray-500 space-y-2">
                            <p>💡 <strong>How it works:</strong></p>
                            <p>1. Add your property details</p>
                            <p>2. Wait for admin approval</p>
                            <p>3. Pay the 5% listing fee</p>
                            <p>4. Your property goes live!</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Billing Information -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Billing Information</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" value="{{ auth()->user()->name }}" class="form-input">
                </div>
                
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" value="{{ auth()->user()->email }}" class="form-input">
                </div>
                
                <div>
                    <label class="form-label">Phone Number</label>
                    <input type="tel" value="{{ auth()->user()->phone }}" class="form-input">
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Address</label>
                    <textarea rows="3" placeholder="Billing address..." class="form-input"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">City</label>
                        <input type="text" placeholder="City" class="form-input">
                    </div>
                    
                    <div>
                        <label class="form-label">Postal Code</label>
                        <input type="text" placeholder="Postal Code" class="form-input">
                    </div>
                </div>
                
                <button class="btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Billing Info
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
