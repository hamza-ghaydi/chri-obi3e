@extends('layouts.main')

@section('title', 'Next Step - ' . $property->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Modern Header with Gradient -->
        <div class="mb-8">
            <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative z-10">
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-3">Continue the Process</h1>
                            <p class="text-white/80 text-lg">Proceed to review property documents with the owner</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-file-signature text-6xl text-[#CBA660]/30"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <!-- Next Step Card -->
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-[#CBA660] rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-file-signature text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-[#2F2B40] mb-2">Next Step: Review with Owner</h2>
                                <p class="text-gray-600">Document review and final decision process</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/10 p-6 rounded-2xl mb-8">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-[#CBA660]/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-info-circle text-[#CBA660] text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-[#2F2B40] mb-3">What happens next?</h3>
                                    <p class="text-gray-700 leading-relaxed mb-4">
                                        You have successfully scheduled a visit. The next step is to continue the process with the property owner, where you will review legal and ownership documents of the property before making a final decision.
                                    </p>
                                    
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                        <div class="flex items-center bg-white/80 p-4 rounded-xl">
                                            
                                            <span class="text-gray-700 font-medium">Legal Documents Review</span>
                                        </div>
                                        
                                        <div class="flex items-center bg-white/80 p-4 rounded-xl">
                                            
                                            <span class="text-gray-700 font-medium">Owner Consultation</span>
                                        </div>
                                        
                                        <div class="flex items-center bg-white/80 p-4 rounded-xl">
                                            
                                            <span class="text-gray-700 font-medium">Property Verification</span>
                                        </div>
                                        
                                        <div class="flex items-center bg-white/80 p-4 rounded-xl">
                                            
                                            <span class="text-gray-700 font-medium">Final Decision</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Form -->
                        <div class="text-center bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-8 rounded-2xl">
                            <div class="mb-6">
                                <div class="w-16 h-16 bg-[#CBA660] rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-arrow-right text-white text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#2F2B40] mb-2">Ready to Continue?</h3>
                                <p class="text-gray-600">Start the document review process with the property owner</p>
                            </div>
                            
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-4 px-8 rounded-xl hover:shadow-lg transition-all duration-300 font-bold text-lg transform hover:scale-105">
                                    <i class="fas fa-file-signature mr-3"></i>Continue to Document Review with Owner
                                </button>
                            </form>
                            
                            <!-- Additional Info -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-center text-sm text-gray-600">
                                    <i class="fas fa-shield-alt text-[#CBA660] mr-2"></i>
                                    <span>Secure and verified document review process</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Property Quick View -->
                <div class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-[#2F2B40]">{{ $property->title }}</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-[#CBA660]"></i>
                                </div>
                                <span class="text-gray-700 font-medium text-sm">{{ $property->address }}</span>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 p-3 rounded-xl">
                                <div class="w-8 h-8 bg-[#CBA660] rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                                <span class="text-[#CBA660] font-bold">{{ $property->formatted_price }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('properties.show', $property) }}" 
                           class="block text-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-3 rounded-xl hover:shadow-lg transition-all duration-300 font-bold transform hover:scale-105">
                            <i class="fas fa-eye mr-2"></i>View Full Details
                        </a>
                    </div>
                </div>

                

                <!-- Support Card -->
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-[#CBA660]/10 px-6 py-4">
                        <h3 class="text-lg font-bold text-[#CBA660] flex items-center">
                            <i class="fas fa-headset mr-2"></i>Need Help?
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            Our support team is available to assist you throughout the document review process.
                        </p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                <div class="w-8 h-8 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone "></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-700">Call Support</div>
                                    <div class="text-xs text-gray-500">+212 000 000 000</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                <div class="w-8 h-8 flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope "></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-700">Email Support</div>
                                    <div class="text-xs text-gray-500">info@chriwbi3.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection