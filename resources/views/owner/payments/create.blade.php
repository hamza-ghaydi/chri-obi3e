@extends('layouts.dashboard')

@section('title', 'Pay Listing Fee - Owner Dashboard')
@section('page-title', 'Pay Listing Fee')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('owner.payments.index') }}" class="hover:text-brand-dark">Payments</a>
<span class="mx-2">/</span>
<span>Pay Listing Fee</span>
@endsection

@section('content')
<div class="space-y-6">
    @if($property)
        <!-- Selected Property -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Property to Publish</h3>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Approved</span>
            </div>
            
            <div class="flex items-start space-x-6">
                <img src="{{ $property->featured_image_url }}" 
                     alt="{{ $property->title }}" 
                     class="w-32 h-24 object-cover rounded-lg">
                
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-brand-dark mb-2">{{ $property->title }}</h4>
                    <div class="flex items-center text-gray-600 mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $property->address }}, {{ $property->city->name }}</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm">
                        <span class="property-status {{ $property->isForSale() ? 'status-sale' : 'status-rent' }}">
                            {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                        </span>
                        <span class="text-gray-600">{{ $property->category->name }}</span>
                    </div>
                </div>
                
                <div class="text-right">
                    <div class="property-price text-2xl mb-1">{{ $property->formatted_price }}</div>
                    <div class="text-sm text-gray-600">Property Price</div>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Payment Breakdown -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Payment Breakdown</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Property Price:</span>
                        <span class="font-semibold">{{ $property->formatted_price }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Listing Fee (5%):</span>
                        <span class="font-semibold text-brand-beige">{{ number_format($property->price * 0.05, 2) }} MAD</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 text-lg font-bold">
                        <span>Total to Pay:</span>
                        <span class="text-brand-dark">{{ number_format($property->price * 0.05, 2) }} MAD</span>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">What happens after payment?</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>✓ Your property will be published immediately</li>
                            <li>✓ It will appear in search results</li>
                            <li>✓ Clients can view and contact you</li>
                            <li>✓ You'll start receiving appointment requests</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Secure Payment</h3>
                    <div class="flex items-center space-x-2">
                        <i class="fab fa-cc-visa text-2xl text-blue-600"></i>
                        <i class="fab fa-cc-mastercard text-2xl text-red-600"></i>
                        <i class="fas fa-lock text-green-600"></i>
                    </div>
                </div>
                
                <form action="{{ route('owner.payments.checkout') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                            <span class="font-semibold text-gray-800">Secure Payment with Stripe</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Your payment is processed securely by Stripe. We never store your card details.
                        </p>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" required class="mr-2">
                                <span class="text-sm">I agree to the <a href="#" class="text-brand-beige hover:underline">Terms of Service</a> and <a href="#" class="text-brand-beige hover:underline">Payment Policy</a></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2">
                                <span class="text-sm">I want to receive email notifications about my property</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full text-lg py-4">
                        <i class="fas fa-credit-card mr-2"></i>
                        Pay {{ number_format($property->price * 0.05, 2) }} MAD Securely
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('owner.properties.show', $property) }}" class="text-gray-600 hover:text-brand-dark text-sm">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Property
                        </a>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Select Property -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Select Property to Pay For</h3>
            </div>
            
            @if($propertiesNeedingPayment->count() > 0)
                <div class="space-y-4">
                    @foreach($propertiesNeedingPayment as $prop)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-beige transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $prop->featured_image_url }}" 
                                         alt="{{ $prop->title }}" 
                                         class="w-20 h-16 object-cover rounded">
                                    
                                    <div>
                                        <h4 class="font-semibold text-brand-dark">{{ $prop->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $prop->city->name }} • {{ $prop->category->name }}</p>
                                        <p class="text-sm text-gray-500">Approved on {{ $prop->approved_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <div class="text-lg font-semibold text-brand-dark">{{ number_format($prop->price * 0.05, 2) }} MAD</div>
                                    <div class="text-sm text-gray-600">Listing Fee</div>
                                    <a href="{{ route('owner.payments.create', ['property' => $prop->id]) }}" 
                                       class="btn-primary mt-2 text-sm">
                                        Pay Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">All Payments Complete!</h3>
                    <p class="text-gray-500 mb-6">You don't have any properties that require payment at this time.</p>
                    <a href="{{ route('owner.properties.index') }}" class="btn-primary">
                        <i class="fas fa-building mr-2"></i>View My Properties
                    </a>
                </div>
            @endif
        </div>
    @endif

    <!-- Payment FAQ -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Payment FAQ</h3>
        </div>
        
        <div class="space-y-4">
            <div>
                <h4 class="font-semibold text-brand-dark mb-2">Why do I need to pay a listing fee?</h4>
                <p class="text-gray-600 text-sm">The 5% listing fee helps us maintain the platform, provide customer support, and market your property to potential buyers/renters.</p>
            </div>
            
            <div>
                <h4 class="font-semibold text-brand-dark mb-2">When is the fee charged?</h4>
                <p class="text-gray-600 text-sm">The fee is only charged after your property is approved by our admin team and you're ready to publish it.</p>
            </div>
            
            <div>
                <h4 class="font-semibold text-brand-dark mb-2">Is my payment secure?</h4>
                <p class="text-gray-600 text-sm">Yes! We use Stripe for payment processing, which is bank-level secure. We never store your card details on our servers.</p>
            </div>
            
            <div>
                <h4 class="font-semibold text-brand-dark mb-2">Can I get a refund?</h4>
                <p class="text-gray-600 text-sm">Refunds are available within 7 days if you decide to unpublish your property. Contact support for assistance.</p>
            </div>
        </div>
    </div>
</div>
@endsection
