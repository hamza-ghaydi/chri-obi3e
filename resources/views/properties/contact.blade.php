@extends('layouts.app')

@section('title', 'Contact Owner - ' . $property->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="text-sm text-gray-600 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('properties.show', $property) }}" class="hover:text-brand-dark">{{ $property->title }}</a>
                <span class="mx-2">/</span>
                <span>Contact Owner</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Contact Property Owner</h1>
            <p class="text-gray-600">Send a message to the owner about this property</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-brand-dark mb-6">Send Message to Owner</h2>
                    
                    <form action="{{ route('properties.contact.store', $property) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Name *</label>
                                <input type="text" name="client_name" value="{{ old('client_name', Auth::user()->name ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent" 
                                       placeholder="Enter your full name" required>
                                @error('client_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Email *</label>
                                <input type="email" name="client_email" value="{{ old('client_email', Auth::user()->email ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent" 
                                       placeholder="Enter your email address" required>
                                @error('client_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Phone Number</label>
                            <input type="tel" name="client_phone" value="{{ old('client_phone', Auth::user()->phone ?? '') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent" 
                                   placeholder="Enter your phone number">
                            @error('client_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message to Owner *</label>
                            <textarea name="message" rows="6" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent" 
                                      placeholder="Hi, I'm interested in this property. I would like to know more details about..." required>{{ old('message', "Hi, I'm interested in your property: " . $property->title . ". I would like to schedule a visit and learn more about the details. Please let me know your availability.") }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                                <div class="text-sm text-blue-700">
                                    <p class="font-semibold mb-1">What happens next?</p>
                                    <ol class="list-decimal list-inside space-y-1">
                                        <li>Your message will be sent to the property owner</li>
                                        <li>You'll be redirected to schedule a visit</li>
                                        <li>The owner will receive your visit request</li>
                                        <li>Once approved, you can proceed with payment</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-brand-dark text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 font-semibold">
                                <i class="fas fa-paper-plane mr-2"></i>Send Message & Continue
                            </button>
                            
                            <a href="{{ route('properties.show', $property) }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Property
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Property Summary -->
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

                <!-- Owner Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">Property Owner</h3>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ $property->owner->profile_picture_url }}" alt="{{ $property->owner->name }}" 
                             class="w-12 h-12 rounded-full">
                        <div>
                            <div class="font-semibold text-brand-dark">{{ $property->owner->name }}</div>
                            <div class="text-sm text-gray-600">Property Owner</div>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-600 space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-brand-beige"></i>
                            {{ $property->owner->email }}
                        </div>
                        
                        @if($property->owner->phone)
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2 text-brand-beige"></i>
                                {{ $property->owner->phone }}
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-brand-beige"></i>
                            Member since {{ $property->owner->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Contact Tips -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>Contact Tips
                    </h3>
                    
                    <ul class="text-sm text-green-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Be specific about your interest and requirements
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Mention your preferred viewing times
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Ask about any additional costs or requirements
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Be professional and courteous in your message
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
