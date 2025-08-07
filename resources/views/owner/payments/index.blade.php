@extends('layouts.dashboard')

@section('title', 'Payments - Owner Dashboard')
@section('page-title', 'Payment History')

@section('content')
<div class="space-y-8">
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Payment History</h2>
                <p class="text-white/80 text-lg">Track your listing fees and payment transactions</p>
            </div>
            
        </div>
    </div>

    <!-- Payment History -->
    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Payment History</h3>
                    <p class="text-gray-600">Track all your payment transactions</p>
                </div>
                <div class="flex space-x-3">
                    <select class="bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                        <option>All Status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Failed</option>
                    </select>
                    <input type="month" class="bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                </div>
            </div>
        </div>
        
        @if($payments->count() > 0)
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Transaction ID</th>
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Property</th>
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Amount</th>
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Status</th>
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Date</th>
                                <th class="text-left py-4 px-4 font-semibold text-[#2F2B40]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($payments as $payment)
                                <tr class="group hover:bg-gradient-to-r hover:from-[#2F2B40]/5 hover:to-[#CBA660]/5 transition-all duration-300">
                                    <td class="py-4 px-4">
                                        <div class="font-mono text-sm font-semibold text-[#2F2B40]">#{{ $payment->id }}</div>
                                        @if($payment->stripe_charge_id)
                                            <div class="text-xs text-gray-500">{{ Str::limit($payment->stripe_charge_id, 20) }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="font-semibold text-[#2F2B40] group-hover:text-[#CBA660] transition-colors">{{ Str::limit($payment->property->title, 30) }}</div>
                                        <div class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1 text-[#CBA660]"></i>
                                            {{ $payment->property->city->name }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-lg bg-gradient-to-r from-[#2F2B40] to-[#CBA660] bg-clip-text text-transparent">{{ number_format($payment->amount, 2) }} MAD</div>
                                        <div class="text-xs text-gray-500">{{ $payment->fee_percentage }}% fee</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $payment->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-sm font-medium text-[#2F2B40]">{{ $payment->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if($payment->status === 'pending')
                                            <a href="{{ route('owner.payments.create', ['property' => $payment->property_id]) }}"
                                               class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium px-4 py-2 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-sm">
                                                <i class="fas fa-credit-card mr-1"></i>Pay Now
                                            </a>
                                        @elseif($payment->status === 'completed')
                                            <span class="inline-flex items-center bg-green-100 text-green-700 font-medium px-4 py-2 rounded-xl text-sm">
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
                <div class="mt-8 flex justify-center">
                    {{ $payments->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="p-8">
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-receipt text-4xl text-[#CBA660]"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-4">No Payment History</h3>
                        <p class="text-gray-600 mb-8">Your payment history will appear here once you start listing properties.</p>

                        <div class="space-y-6">
                            <a href="{{ route('owner.properties.create') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Add Your First Property
                            </a>

                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-6">
                                <div class="text-sm text-gray-600 space-y-3">
                                    <p class="flex items-center">
                                        <span class="text-xl mr-3">💡</span>
                                        <strong class="text-[#2F2B40]">How it works:</strong>
                                    </p>
                                    <div class="grid grid-cols-1 gap-2 text-left ml-8">
                                        <p class="flex items-center">
                                            <span class="w-6 h-6 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                            Add your property details
                                        </p>
                                        <p class="flex items-center">
                                            <span class="w-6 h-6 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                                            Wait for admin approval
                                        </p>
                                        <p class="flex items-center">
                                            <span class="w-6 h-6 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                                            Pay the 5% listing fee
                                        </p>
                                        <p class="flex items-center">
                                            <span class="w-6 h-6 bg-[#CBA660] text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">4</span>
                                            Your property goes live!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


</div>
@endsection