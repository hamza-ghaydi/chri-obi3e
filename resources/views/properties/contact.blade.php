@extends('layouts.main')

@section('title', 'Contact Owner - ' . $property->title)

@section('content')
    <div class="min-h-screen py-8" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Contact Form --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                            
                            <div
                                class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                                <h2 class="text-2xl font-bold text-[#2F2B40] mb-2">Send Message to Owner</h2>
                                <p class="text-gray-600">Fill out the form below to contact the property owner</p>
                            </div>

                            <div class="p-8">
                                <form action="{{ route('properties.contact.store', $property) }}" method="POST"
                                    class="space-y-8">
                                    @csrf

                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#2F2B40] mb-4 flex items-center">
                                            <div
                                                class="w-1 h-6 bg-gradient-to-b from-[#CBA660] to-[#CBA660]/60 rounded-full mr-3">
                                            </div>
                                            Personal Information
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="group">
                                                <label class="block text-sm font-semibold text-gray-700 mb-3">Your Name
                                                    *</label>
                                                <div class="relative">
                                                    <input type="text" name="client_name"
                                                        value="{{ old('client_name', Auth::user()->name ?? '') }}"
                                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 group-hover:border-[#CBA660]/50"
                                                        placeholder="Enter your full name" required>
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                        <i
                                                            class="fas fa-user text-gray-400 group-focus-within:text-[#CBA660] transition-colors duration-300"></i>
                                                    </div>
                                                </div>
                                                @error('client_name')
                                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>

                                            <div class="group">
                                                <label class="block text-sm font-semibold text-gray-700 mb-3">Your Email
                                                    *</label>
                                                <div class="relative">
                                                    <input type="email" name="client_email"
                                                        value="{{ old('client_email', Auth::user()->email ?? '') }}"
                                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 group-hover:border-[#CBA660]/50"
                                                        placeholder="Enter your email address" required>
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                        <i
                                                            class="fas fa-envelope text-gray-400 group-focus-within:text-[#CBA660] transition-colors duration-300"></i>
                                                    </div>
                                                </div>
                                                @error('client_email')
                                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Your Phone
                                            Number</label>
                                        <div class="relative">
                                            <input type="tel" name="client_phone"
                                                value="{{ old('client_phone', Auth::user()->phone ?? '') }}"
                                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 group-hover:border-[#CBA660]/50"
                                                placeholder="Enter your phone number">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                <i
                                                    class="fas fa-phone text-gray-400 group-focus-within:text-[#CBA660] transition-colors duration-300"></i>
                                            </div>
                                        </div>
                                        @error('client_phone')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Message -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#2F2B40] mb-4 flex items-center">
                                            <div
                                                class="w-1 h-6 bg-gradient-to-b from-[#CBA660] to-[#CBA660]/60 rounded-full mr-3">
                                            </div>
                                            Your Message
                                        </h3>

                                        <div class="group">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Message to Owner
                                                *</label>
                                            <textarea name="message" rows="8"
                                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 group-hover:border-[#CBA660]/50 resize-none"
                                                placeholder="Hi, I'm interested in this property. I would like to know more details about..." required>{{ old('message', "Hi, I'm interested in your property: " . $property->title . '. I would like to schedule a visit and learn more about the details. Please let me know your availability.') }}</textarea>
                                            @error('message')
                                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Process Information -->
                                    <div
                                        class=" p-6 rounded-2xl border border-[#CBA660]">
                                        <div class="flex items-start">
                                            
                                            <div>
                                                <h4 class="font-bold text-[#2F2B40] mb-3 text-xl">What happens next?</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                                    <div class="flex items-start">
                                                        <div
                                                            class="w-8 h-8 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 mt-1">
                                                            1</div>
                                                        <span class="text-gray-700 font-medium">Your message will be sent to
                                                            the property owner</span>
                                                    </div>
                                                    <div class="flex items-start">
                                                        <div
                                                            class="w-8 h-8 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 mt-1">
                                                            2</div>
                                                        <span class="text-gray-700 font-medium">You'll be redirected to
                                                            schedule a visit</span>
                                                    </div>
                                                    <div class="flex items-start">
                                                        <div
                                                            class="w-8 h-8 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 mt-1">
                                                            3</div>
                                                        <span class="text-gray-700 font-medium">The owner will receive your
                                                            visit request</span>
                                                    </div>
                                                    <div class="flex items-start">
                                                        <div
                                                            class="w-8 h-8 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 mt-1">
                                                            4</div>
                                                        <span class="text-gray-700 font-medium">Once your visit is approved, continue the process directly with the property owner.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                        <button type="submit"
                                            class="flex-1 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-4 px-8 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 font-semibold text-lg flex items-center justify-center">
                                            <i class="fas fa-paper-plane mr-3"></i>Send Message & Continue
                                        </button>

                                        <a href="{{ route('properties.show', $property) }}"
                                            class="sm:w-auto bg-white border-2 border-[#2F2B40] text-[#2F2B40] py-4 px-8 rounded-xl hover:bg-[#2F2B40] hover:text-white transition-all duration-300 transform hover:scale-105 font-semibold text-lg flex items-center justify-center">
                                            <i class="fas fa-arrow-left mr-3"></i>Back to Property
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="space-y-8">
                        
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden group">
                            <div class="relative">
                                <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}"
                                    class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                <div class="absolute bottom-4 right-4">
                                    <span
                                        class="px-3 py-1 rounded-lg text-sm font-semibold backdrop-blur-sm text-white
                                    {{ $property->isForSale() ? 'bg-[#CBA660]/90' : 'bg-[#2F2B40]/90' }}">
                                        {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-[#2F2B40] mb-3 line-clamp-2">{{ $property->title }}</h3>

                                <div class="space-y-3 text-sm mb-6">
                                    <div
                                        class="flex items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                        <i class="fas fa-map-marker-alt mr-3 text-[#CBA660]"></i>
                                        <span class="text-gray-700 font-medium">{{ $property->address }},
                                            {{ $property->city->name }}</span>
                                    </div>

                                    <div
                                        class="flex items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                        <i class="fas fa-tag mr-3 text-[#CBA660]"></i>
                                        <span class="text-gray-700 font-medium">{{ $property->category->name }}</span>
                                    </div>

                                    <div
                                        class="flex items-center p-3 bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/5 rounded-xl">
                                        <i class="fas fa-dollar-sign mr-3 text-[#CBA660]"></i>
                                        <span
                                            class="text-[#2F2B40] font-bold text-lg">{{ $property->formatted_price }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3">
                                    @if ($property->bedrooms)
                                        <div
                                            class="bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/10 p-3 rounded-xl text-center">
                                            <div class="text-xl font-bold text-[#2F2B40]">{{ $property->bedrooms }}</div>
                                            <div class="text-xs text-gray-600 font-medium">Beds</div>
                                        </div>
                                    @endif
                                    @if ($property->bathrooms)
                                        <div
                                            class="bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/10 p-3 rounded-xl text-center">
                                            <div class="text-xl font-bold text-[#2F2B40]">{{ $property->bathrooms }}</div>
                                            <div class="text-xs text-gray-600 font-medium">Baths</div>
                                        </div>
                                    @endif
                                    @if ($property->area)
                                        <div
                                            class="bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/10 p-3 rounded-xl text-center">
                                            <div class="text-xl font-bold text-[#2F2B40]">
                                                {{ number_format($property->area) }}</div>
                                            <div class="text-xs text-gray-600 font-medium">m²</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Owner Info -->
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-[#2F2B40]/10 to-[#CBA660]/10 p-6 border-b border-gray-100">
                                <h3 class="text-xl font-bold text-[#2F2B40]">Property Owner</h3>
                            </div>

                            <div class="p-6">
                                <div
                                    class="flex items-center space-x-4 mb-6 p-4 bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl">
                                    
                                    <div>
                                        <div class="text-lg font-bold text-[#2F2B40]">{{ $property->owner->name }}</div>
                                        <div class="text-sm text-gray-600 font-medium">Property Owner</div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div
                                        class="flex items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                        <i class="fas fa-envelope mr-3 text-[#CBA660]"></i>
                                        <span class="text-gray-700 font-medium">{{ $property->owner->email }}</span>
                                    </div>

                                    @if ($property->owner->phone)
                                        <div
                                            class="flex items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                            <i class="fas fa-phone mr-3 text-[#CBA660]"></i>
                                            <span class="text-gray-700 font-medium">{{ $property->owner->phone }}</span>
                                        </div>
                                    @endif

                                    
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
