@extends('layouts.dashboard')

@section('title', 'My Properties - Client Dashboard')
@section('page-title', 'My Properties')

@section('content')
<div class="space-y-8">
    
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">My Properties</h2>
                <p class="text-white/80 text-lg">Properties you've purchased or rented</p>
            </div>
            
        </div>
    </div>

    {{-- Current Properties --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Current Properties</h3>
                    <p class="text-gray-600">Your real estate portfolio</p>
                </div>
                <div class="flex space-x-3">
                    <select class="bg-white border border-gray-300 rounded-xl px-7 py-3 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                        <option>All Types</option>
                        <option>Purchased</option>
                        <option>Rented</option>
                    </select>
                    <select class="bg-white border border-gray-300 rounded-xl px-7 py-3 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                        <option>All Cities</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Empty State -->
        <div class="p-8">
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-home text-4xl text-[#CBA660]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-4">No Properties Yet</h3>
                    <p class="text-gray-600 mb-8">You haven't purchased or rented any properties yet. Start browsing to find your perfect home!</p>
                    
                    <div class="space-y-6">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Browse Properties
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
{{-- to do --}}
    {{-- Property Search Preferences --}}
    {{-- <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <h3 class="text-2xl font-bold text-[#2F2B40] flex items-center">
                <i class="fas fa-cog mr-3 text-[#CBA660]"></i>
                Search Preferences
            </h3>
            <p class="text-gray-600 text-sm mt-1">Customize your property search criteria</p>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-2xl p-6">
                        <h4 class="font-bold text-[#2F2B40] mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-[#CBA660]"></i>
                            Preferred Locations
                        </h4>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-city mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Casablanca</span>
                            </label>
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-city mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Rabat</span>
                            </label>
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-city mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Marrakech</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-[#CBA660]/5 to-[#CBA660]/10 rounded-2xl p-6">
                        <h4 class="font-bold text-[#2F2B40] mb-4 flex items-center">
                            <i class="fas fa-home mr-2 text-[#CBA660]"></i>
                            Property Types
                        </h4>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-building mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Apartment</span>
                            </label>
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-home mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Villa</span>
                            </label>
                            <label class="flex items-center p-3 bg-white rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                <i class="fas fa-door-open mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-sm font-medium text-[#2F2B40]">Studio</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#2F2B40] mb-3">Budget Range (MAD)</label>
                        <div class="flex space-x-3">
                            <input type="number" placeholder="Min" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                            <input type="number" placeholder="Max" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-[#2F2B40] mb-3">Minimum Bedrooms</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                            <option>Any</option>
                            <option>1+</option>
                            <option>2+</option>
                            <option>3+</option>
                            <option>4+</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Save Preferences
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection