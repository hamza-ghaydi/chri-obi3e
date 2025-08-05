@extends('layouts.app')

@section('title', 'Payment - ' . $property->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="text-sm text-gray-600 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('properties.show', $property) }}" class="hover:text-brand-dark">{{ $property->title }}</a>
                <span class="mx-2">/</span>
                <span>Payment</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Complete Your Payment</h1>
            <p class="text-gray-600">Finalize your property acquisition with secure payment</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Options -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payment Type Selection -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-brand-dark mb-6">
                        @if($property->listing_type === 'rent')
                            Monthly Rent Payment
                        @else
                            Property Purchase
                        @endif
                    </h2>

                    @if($property->listing_type === 'rent')
                        <!-- Rent Payment Option -->
                        <div class="payment-option border-2 border-brand-beige rounded-lg p-6 bg-blue-50"
                             onclick="selectPaymentType('monthly_rent')">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-home text-3xl text-blue-600"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-brand-dark mb-2">Monthly Rent</h3>
                                <p class="text-gray-600 mb-4">Pay monthly rent for this property</p>
                                <div class="text-3xl font-bold text-blue-600 mb-2">
                                    {{ $property->formatted_price }}
                                </div>
                                <p class="text-sm text-gray-600 mb-4">per month</p>

                                <div class="bg-white p-4 rounded-lg border border-blue-200">
                                    <h4 class="font-semibold text-brand-dark mb-2">What's Included:</h4>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        <li>✓ Monthly rental access</li>
                                        <li>✓ Automatic recurring payments</li>
                                        <li>✓ Property maintenance included</li>
                                        <li>✓ Cancel anytime with 30 days notice</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Purchase Payment Option -->
                        <div class="payment-option border-2 border-brand-beige rounded-lg p-6 bg-green-50"
                             onclick="selectPaymentType('full_purchase')">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-key text-3xl text-green-600"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-brand-dark mb-2">Purchase Property</h3>
                                <p class="text-gray-600 mb-4">Buy this property with full ownership</p>
                                <div class="text-3xl font-bold text-green-600 mb-2">
                                    {{ $property->formatted_price }}
                                </div>
                                <p class="text-sm text-gray-600 mb-4">one-time payment</p>

                                <div class="bg-white p-4 rounded-lg border border-green-200">
                                    <h4 class="font-semibold text-brand-dark mb-2">What You Get:</h4>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        <li>✓ Full property ownership</li>
                                        <li>✓ Property deed and title</li>
                                        <li>✓ No monthly payments</li>
                                        <li>✓ Investment opportunity</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Payment Form -->
                <div id="payment-form" class="bg-white rounded-lg shadow-lg p-6" style="display: none;">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">Payment Details</h3>
                    
                    <form action="{{ route('payments.checkout', $property) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <input type="hidden" id="payment_type" name="payment_type" value="">
                        <input type="hidden" id="amount" name="amount" value="">
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-blue-800">Selected Option:</p>
                                    <p id="selected-option" class="text-blue-700"></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-blue-800">Amount:</p>
                                    <p id="selected-amount" class="text-2xl font-bold text-blue-700"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-500 mt-1 mr-3"></i>
                                <div class="text-sm text-yellow-700">
                                    <p class="font-semibold mb-1">Payment Information:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Secure payment processing via Stripe</li>
                                        <li>All major credit and debit cards accepted</li>
                                        <li>Your payment information is encrypted and secure</li>
                                        <li>You'll receive a confirmation email after payment</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="terms" required class="mr-2">
                                <label for="terms" class="text-sm text-gray-700">
                                    I agree to the <a href="#" class="text-brand-dark hover:underline">Terms and Conditions</a> 
                                    and <a href="#" class="text-brand-dark hover:underline">Privacy Policy</a>
                                </label>
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" class="flex-1 bg-brand-dark text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 font-semibold">
                                    <i class="fas fa-credit-card mr-2"></i>Proceed to Secure Payment
                                </button>
                                
                                <button type="button" onclick="resetPaymentSelection()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-semibold">
                                    <i class="fas fa-arrow-left mr-2"></i>Back
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Security Information -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">
                        <i class="fas fa-shield-alt mr-2"></i>Secure Payment
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-green-700">
                        <div class="flex items-center">
                            <i class="fas fa-lock mr-2 text-green-600"></i>
                            <span>256-bit SSL encryption</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-credit-card mr-2 text-green-600"></i>
                            <span>PCI DSS compliant</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2 text-green-600"></i>
                            <span>Fraud protection</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-undo mr-2 text-green-600"></i>
                            <span>Refund protection</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Property Summary -->
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

                <!-- Appointment Confirmation -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">
                        <i class="fas fa-calendar-check mr-2 text-green-600"></i>Confirmed Appointment
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="text-gray-600">Visit Date:</label>
                            <p class="font-semibold text-brand-dark">{{ $confirmedAppointment->appointment_date->format('F j, Y') }}</p>
                        </div>
                        
                        <div>
                            <label class="text-gray-600">Visit Time:</label>
                            <p class="font-semibold text-brand-dark">{{ $confirmedAppointment->appointment_date->format('g:i A') }}</p>
                        </div>
                        
                        <div>
                            <label class="text-gray-600">Status:</label>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">
                                Confirmed
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Process Steps -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">
                        <i class="fas fa-route mr-2"></i>Process Steps
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 1: Contact Owner - Completed</span>
                        </div>
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 2: Schedule Visit - Confirmed</span>
                        </div>
                        <div class="flex items-center text-blue-700 font-semibold">
                            <i class="fas fa-arrow-right mr-2"></i>
                            <span>→ Step 3: Complete Payment - In Progress</span>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-headset mr-2"></i>Need Help?
                    </h3>
                    
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
    </div>
</div>

<script>
function selectPaymentType(type) {
    // Remove active class from all options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('border-brand-beige', 'bg-brand-beige', 'bg-opacity-10');
        option.classList.add('border-gray-200');
    });
    
    // Add active class to selected option
    event.currentTarget.classList.remove('border-gray-200');
    event.currentTarget.classList.add('border-brand-beige', 'bg-brand-beige', 'bg-opacity-10');
    
    // Set form values
    document.getElementById('payment_type').value = type;
    
    let amount, optionText;
    if (type === 'monthly_rent') {
        amount = {{ $property->price }};
        optionText = 'Monthly Rent Payment';
    } else if (type === 'full_purchase') {
        amount = {{ $property->price }};
        optionText = 'Full Property Purchase';
    }
    
    document.getElementById('amount').value = amount;
    document.getElementById('selected-option').textContent = optionText;
    document.getElementById('selected-amount').textContent = '$' + (amount/10).toLocaleString() + ' USD (≈' + amount.toLocaleString() + ' MAD)';
    
    // Show payment form
    document.getElementById('payment-form').style.display = 'block';
    document.getElementById('payment-form').scrollIntoView({ behavior: 'smooth' });
}

// Auto-select the payment option on page load
document.addEventListener('DOMContentLoaded', function() {
    @if($property->listing_type === 'rent')
        selectPaymentType('monthly_rent');
    @else
        selectPaymentType('full_purchase');
    @endif
});

function resetPaymentSelection() {
    // Reset form
    document.getElementById('payment_type').value = '';
    document.getElementById('amount').value = '';
    
    // Remove active classes
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('border-brand-beige', 'bg-brand-beige', 'bg-opacity-10');
        option.classList.add('border-gray-200');
    });
    
    // Hide form
    document.getElementById('payment-form').style.display = 'none';
}
</script>
@endsection
