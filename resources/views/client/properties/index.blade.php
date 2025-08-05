@extends('layouts.dashboard')

@section('title', 'My Properties - Client Dashboard')
@section('page-title', 'My Properties')

@section('breadcrumb')
<a href="{{ route('client.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>My Properties</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Properties you've purchased or rented</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('home') }}" class="btn-primary">
                <i class="fas fa-search mr-2"></i>Browse More Properties
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0</div>
                    <div class="dashboard-stat-label">Total Properties</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-home text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0</div>
                    <div class="dashboard-stat-label">Purchased</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-key text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0</div>
                    <div class="dashboard-stat-label">Rented</div>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-calendar-alt text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">0 MAD</div>
                    <div class="dashboard-stat-label">Total Investment</div>
                </div>
                <div class="text-brand-beige">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Properties -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Current Properties</h3>
            <div class="flex space-x-2">
                <select class="form-input text-sm">
                    <option>All Types</option>
                    <option>Purchased</option>
                    <option>Rented</option>
                </select>
                <select class="form-input text-sm">
                    <option>All Cities</option>
                </select>
            </div>
        </div>
        
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <i class="fas fa-home text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Properties Yet</h3>
                <p class="text-gray-500 mb-8">You haven't purchased or rented any properties yet. Start browsing to find your perfect home!</p>
                
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="btn-primary inline-block">
                        <i class="fas fa-search mr-2"></i>Browse Properties
                    </a>
                    
                    <div class="text-sm text-gray-500">
                        <p>💡 Tip: Use the favorites feature to save properties you're interested in</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Management Tools -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Property Management Tools</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-blue-50 rounded-lg">
                <i class="fas fa-file-contract text-blue-500 text-3xl mb-3"></i>
                <h4 class="font-semibold text-blue-900 mb-2">Contracts & Documents</h4>
                <p class="text-sm text-blue-700 mb-4">Access your property contracts, lease agreements, and important documents.</p>
                <button class="btn-outline text-sm">View Documents</button>
            </div>
            
            <div class="text-center p-6 bg-green-50 rounded-lg">
                <i class="fas fa-tools text-green-500 text-3xl mb-3"></i>
                <h4 class="font-semibold text-green-900 mb-2">Maintenance Requests</h4>
                <p class="text-sm text-green-700 mb-4">Submit and track maintenance requests for your rented properties.</p>
                <button class="btn-outline text-sm">Request Service</button>
            </div>
            
            <div class="text-center p-6 bg-purple-50 rounded-lg">
                <i class="fas fa-credit-card text-purple-500 text-3xl mb-3"></i>
                <h4 class="font-semibold text-purple-900 mb-2">Payment History</h4>
                <p class="text-sm text-purple-700 mb-4">View your payment history, receipts, and upcoming payment schedules.</p>
                <button class="btn-outline text-sm">View Payments</button>
            </div>
        </div>
    </div>

    <!-- Property Search Preferences -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Search Preferences</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h4 class="font-semibold text-brand-dark">Preferred Locations</h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Casablanca</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Rabat</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Marrakech</span>
                    </label>
                </div>
            </div>
            
            <div class="space-y-4">
                <h4 class="font-semibold text-brand-dark">Property Types</h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Apartment</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Villa</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-sm">Studio</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Budget Range (MAD)</label>
                    <div class="flex space-x-2">
                        <input type="number" placeholder="Min" class="form-input">
                        <input type="number" placeholder="Max" class="form-input">
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Minimum Bedrooms</label>
                    <select class="form-input">
                        <option>Any</option>
                        <option>1+</option>
                        <option>2+</option>
                        <option>3+</option>
                        <option>4+</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button class="btn-primary w-full">
                        <i class="fas fa-save mr-2"></i>Save Preferences
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
