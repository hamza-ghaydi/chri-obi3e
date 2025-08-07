@extends('layouts.dashboard')

@section('title', 'Pay Listing Fee - Owner Dashboard')
@section('page-title', 'Pay Listing Fee')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-[#CBA660]">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('owner.payments.index') }}" class="hover:text-[#CBA660]">Payments</a>
<span class="mx-2">/</span>
<span>Pay Listing Fee</span>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Header Section with Gradient Background -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Secure Payment</h2>
                    <p class="text-white/80 text-lg">Complete your property listing payment securely</p>
                </div>
            </div>
        </div>
    </div>

    @if($property)
        
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property to Publish</h3>
                        <p class="text-gray-600">Ready for payment and listing</p>
                    </div>
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>Approved
                    </span>
                </div>
            </div>
            
            <div class="p-8">
                <div class="flex items-start space-x-6">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg group">
                        <img src="{{ $property->featured_image_url }}" 
                             alt="{{ $property->title }}" 
                             class="w-40 h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-[#2F2B40] mb-3 hover:text-[#CBA660] transition-colors cursor-pointer">{{ $property->title }}</h4>
                        <div class="flex items-center text-gray-600 mb-3">
                            <i class="fas fa-map-marker-alt mr-2 text-[#CBA660]"></i>
                            <span class="font-medium">{{ $property->address }}, {{ $property->city->name }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $property->isForSale() ? 'bg-[#CBA660]/20 text-[#CBA660]' : 'bg-[#2F2B40]/20 text-[#2F2B40]' }}">
                                {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ $property->category->name }}</span>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-3xl font-bold bg-gradient-to-r from-[#2F2B40] to-[#CBA660] bg-clip-text text-transparent mb-2">
                            {{ $property->formatted_price }}
                        </div>
                        <div class="text-sm text-gray-600 font-medium">Property Price</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Payment Breakdown -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Payment Breakdown</h3>
                    <p class="text-gray-600">Detailed cost analysis</p>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="flex justify-between items-center py-4 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Property Price:</span>
                        <span class="font-bold text-lg text-[#2F2B40]">{{ $property->formatted_price }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-4 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Listing Fee (5%):</span>
                        <span class="font-bold text-lg text-[#CBA660]">{{ number_format($property->price * 0.05, 2) }} MAD</span>
                    </div>
                    
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-[#2F2B40]">Total to Pay:</span>
                            <span class="text-2xl font-bold bg-gradient-to-r from-[#2F2B40] to-[#CBA660] bg-clip-text text-transparent">
                                {{ number_format($property->price * 0.05, 2) }} MAD
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Secure Payment</h3>
                            <p class="text-gray-600">Your data is protected</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-cc-visa text-3xl text-blue-600"></i>
                            <i class="fab fa-cc-mastercard text-3xl text-red-600"></i>
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-lock text-green-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('owner.payments.checkout') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-green-900 mb-2">Secure Payment with Stripe</h4>
                                    <p class="text-sm text-green-800">
                                        Your payment is processed securely by Stripe. We never store your card details on our servers.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-4">
                                <label class="flex items-start cursor-pointer group">
                                    <input type="checkbox" required class="mt-1 mr-3 w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span class="text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">
                                        I agree to the <a href="#" class="text-[#CBA660] hover:text-[#2F2B40] font-semibold underline">Terms of Service</a> and <a href="#" class="text-[#CBA660] hover:text-[#2F2B40] font-semibold underline">Payment Policy</a>
                                    </span>
                                </label>
                            </div>
                            
                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-4">
                                <label class="flex items-start cursor-pointer group">
                                    <input type="checkbox" class="mt-1 mr-3 w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span class="text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">
                                        I want to receive email notifications about my property listings and inquiries
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-bold text-lg py-4 px-8 rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-credit-card mr-3 text-xl"></i>
                            Pay {{ number_format($property->price * 0.05, 2) }} MAD Securely
                        </button>
                        
                        <div class="text-center pt-4">
                            <a href="{{ route('owner.properties.show', $property) }}" class="inline-flex items-center text-gray-600 hover:text-[#CBA660] font-medium transition-colors duration-300">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Property
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Select Property -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Select Property to Pay For</h3>
                <p class="text-gray-600">Choose which approved property you'd like to publish</p>
            </div>
            
            <div class="p-8">
                @if($propertiesNeedingPayment->count() > 0)
                    <div class="space-y-6">
                        @foreach($propertiesNeedingPayment as $prop)
                            <div class="group border border-gray-200 hover:border-[#CBA660] rounded-xl p-6 transition-all duration-300 hover:shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start space-x-6">
                                        <div class="relative overflow-hidden rounded-xl shadow-md group-hover:shadow-lg transition-shadow">
                                            <img src="{{ $prop->featured_image_url }}" 
                                                 alt="{{ $prop->title }}" 
                                                 class="w-24 h-20 object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        
                                        <div>
                                            <h4 class="font-bold text-[#2F2B40] text-lg group-hover:text-[#CBA660] transition-colors">{{ $prop->title }}</h4>
                                            <div class="flex items-center text-gray-600 mt-2 mb-1">
                                                <i class="fas fa-map-marker-alt mr-2 text-[#CBA660]"></i>
                                                <span class="font-medium">{{ $prop->city->name }} • {{ $prop->category->name }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                                <span>Approved on {{ $prop->approved_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-[#2F2B40] to-[#CBA660] bg-clip-text text-transparent mb-1">
                                            {{ number_format($prop->price * 0.05, 2) }} MAD
                                        </div>
                                        <div class="text-sm text-gray-600 font-medium mb-4">Listing Fee</div>
                                        <a href="{{ route('owner.payments.create', ['property' => $prop->id]) }}" 
                                           class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-6 py-2 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                            <i class="fas fa-credit-card mr-2"></i>Pay Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-500/20 to-green-500/40 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check-circle text-4xl text-green-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-4">All Payments Complete!</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">You don't have any properties that require payment at this time. All your approved properties are already published.</p>
                        <a href="{{ route('owner.properties.index') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-building mr-2"></i>View My Properties
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection