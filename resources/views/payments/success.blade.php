@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-3xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Payment Successful!</h1>
            <p class="text-gray-600">Your payment has been processed successfully</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-brand-dark mb-6">Payment Summary</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Payment Type</label>
                            <p class="text-lg font-semibold text-brand-dark">
                                @if($payment->payment_type === 'monthly_rent')
                                    Monthly Rent Payment
                                @elseif($payment->payment_type === 'full_purchase')
                                    Full Property Purchase
                                @else
                                    Payment
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Amount Paid</label>
                            <p class="text-lg font-semibold text-green-600">
                                ${{ number_format($payment->amount / 10, 2) }} USD (≈{{ number_format($payment->amount, 2) }} MAD)
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Payment Date</label>
                            <p class="text-lg font-semibold text-brand-dark">
                                {{ $payment->paid_at->format('F j, Y') }}
                            </p>
                            <p class="text-gray-600">
                                {{ $payment->paid_at->format('g:i A') }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Transaction ID</label>
                            <p class="text-sm font-mono text-brand-dark bg-gray-100 p-2 rounded">
                                {{ $payment->stripe_payment_intent_id }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-brand-dark">Status:</span>
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">What Happens Next?</h3>
                    
                    @if($payment->payment_type === 'monthly_rent')
                        <div class="bg-blue-50 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-home text-blue-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="font-semibold text-blue-800 mb-2">Monthly Rent Subscription Active!</p>
                                    <ul class="text-blue-700 text-sm space-y-1">
                                        <li>• Your monthly rent subscription has been set up successfully</li>
                                        <li>• Automatic payments will be processed monthly</li>
                                        <li>• The property owner will contact you with move-in details</li>
                                        <li>• You'll receive the lease agreement within 24-48 hours</li>
                                        <li>• You can manage your subscription in your account dashboard</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @elseif($payment->payment_type === 'full_purchase')
                        <div class="bg-green-50 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-key text-green-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="font-semibold text-green-800 mb-2">Property Purchased!</p>
                                    <ul class="text-green-700 text-sm space-y-1">
                                        <li>• Congratulations! You are now the owner of this property</li>
                                        <li>• Legal documents will be prepared for transfer</li>
                                        <li>• You'll receive ownership papers within 5-7 business days</li>
                                        <li>• Property keys will be handed over after document signing</li>
                                        <li>• Property title will be transferred to your name</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-yellow-500 mt-1 mr-3"></i>
                            <div class="text-sm text-yellow-700">
                                <p class="font-semibold mb-1">Email Confirmation</p>
                                <p>A detailed receipt and next steps have been sent to your email address. Please check your inbox and spam folder.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">Need Assistance?</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-brand-dark mb-2">Property Owner</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2 text-brand-beige"></i>
                                    <span>{{ $property->owner->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-2 text-brand-beige"></i>
                                    <span>{{ $property->owner->email }}</span>
                                </div>
                                @if($property->owner->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2 text-brand-beige"></i>
                                        <span>{{ $property->owner->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-brand-dark mb-2">Customer Support</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-brand-beige"></i>
                                    <span>+212 123 456 789</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-2 text-brand-beige"></i>
                                    <span>support@realestate.com</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-brand-beige"></i>
                                    <span>24/7 Support Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('properties.show', $property) }}" 
                       class="flex-1 bg-brand-dark text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 font-semibold text-center">
                        <i class="fas fa-home mr-2"></i>View Property Details
                    </a>
                    
                    <a href="{{ route('home') }}" 
                       class="flex-1 bg-brand-beige text-brand-dark py-3 px-6 rounded-lg hover:bg-opacity-80 transition duration-300 font-semibold text-center">
                        <i class="fas fa-search mr-2"></i>Browse More Properties
                    </a>
                    
                    <button onclick="window.print()" 
                            class="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-50 transition duration-300 font-semibold">
                        <i class="fas fa-print mr-2"></i>Print Receipt
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Property Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-brand-dark mb-2">{{ $property->title }}</h3>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-brand-beige"></i>
                                {{ $property->address }}, {{ $property->city->name }}
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2 text-brand-beige"></i>
                                {{ $property->category->name }}
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign mr-2 text-brand-beige"></i>
                                {{ $property->formatted_price }}
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-2 text-center text-sm">
                            <div class="bg-gray-50 p-2 rounded">
                                <div class="font-semibold text-brand-dark">{{ $property->bedrooms }}</div>
                                <div class="text-gray-600">Beds</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <div class="font-semibold text-brand-dark">{{ $property->bathrooms }}</div>
                                <div class="text-gray-600">Baths</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <div class="font-semibold text-brand-dark">{{ number_format($property->area) }}</div>
                                <div class="text-gray-600">m²</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Completed -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">
                        <i class="fas fa-check-circle mr-2"></i>Process Complete!
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 1: Contact Owner - Completed</span>
                        </div>
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 2: Schedule Visit - Completed</span>
                        </div>
                        <div class="flex items-center text-green-700 font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 3: Complete Payment - Completed</span>
                        </div>
                    </div>
                </div>

                <!-- Receipt Download -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">
                        <i class="fas fa-receipt mr-2"></i>Receipt & Documents
                    </h3>
                    
                    <div class="space-y-3">
                        <button onclick="window.print()" class="w-full bg-brand-beige text-brand-dark py-2 px-4 rounded hover:bg-opacity-80 transition duration-300 text-sm">
                            <i class="fas fa-download mr-2"></i>Download Receipt
                        </button>
                        
                        <div class="text-xs text-gray-500 text-center">
                            <p>Keep this receipt for your records</p>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="bg-gray-50 rounded-lg p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-2">Secure Payment</h4>
                    <p class="text-xs text-gray-600">Your payment was processed securely using 256-bit SSL encryption</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .shadow-lg {
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}
</style>
@endsection
