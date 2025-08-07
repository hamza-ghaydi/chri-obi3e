@extends('layouts.dashboard')

@section('title', 'Owner Dashboard - Real Estate Platform')
@section('page-title', 'Property Owner Dashboard')

@section('content')
<div class="space-y-8">
    
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-white/80 text-lg">Manage your properties and appointments with ChriWBi3.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-key text-6xl text-[#CBA660]/30"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $propertyStats['total'] }}</div>
                    <div class="text-gray-600 font-medium">Total Properties</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $propertyStats['published'] }}</div>
                    <div class="text-gray-600 font-medium">Published Properties</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Appointments Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $appointmentStats['pending'] }}</div>
                    <div class="text-gray-600 font-medium">Pending Appointments</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Appointments Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $appointmentStats['total'] }}</div>
                    <div class="text-gray-600 font-medium">Total Appointments</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointment Requests -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Recent Appointment Requests</h3>
                            <p class="text-gray-600">Manage your property viewing appointments</p>
                        </div>
                        <a href="{{ route('owner.appointments.index') }}" 
                           class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 text-sm font-medium">
                            View All
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    @if($recentAppointments->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentAppointments as $appointment)
                                <div class="group relative bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:border-[#CBA660]/30">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                    <i class="fas fa-user text-[#CBA660] text-xl"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-[#2F2B40] text-lg">{{ $appointment->client->name }}</div>
                                                <div class="text-sm text-gray-600 mb-1">{{ $appointment->property->title }}</div>
                                                <div class="text-xs text-gray-500">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $appointment->appointment_date->format('M d, Y - H:i') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <span class="px-4 py-2 rounded-full text-xs font-semibold
                                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>

                                            @if($appointment->status === 'pending')
                                                <div class="flex space-x-2">
                                                    <button onclick="updateAppointmentStatus({{ $appointment->id }}, 'confirmed')"
                                                            class="bg-green-100 text-green-600 hover:bg-green-200 text-sm px-3 py-2 rounded-lg border border-green-300 transition-all duration-300 hover:scale-105">
                                                        <i class="fas fa-check mr-1"></i>Approve
                                                    </button>
                                                    <button onclick="updateAppointmentStatus({{ $appointment->id }}, 'rejected')"
                                                            class="bg-red-100 text-red-600 hover:bg-red-200 text-sm px-3 py-2 rounded-lg border border-red-300 transition-all duration-300 hover:scale-105">
                                                        <i class="fas fa-times mr-1"></i>Reject
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-calendar text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-[#2F2B40] mb-2">No appointment requests yet</h3>
                            <p class="text-gray-500">Your appointment requests will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Actions Card  --}}
        <div class="space-y-6">
            
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Quick Actions</h3>
                            <p class="text-gray-600 text-sm">Manage your properties</p>
                        </div>
                        <i class="fas fa-bolt text-2xl text-[#CBA660]"></i>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <a href="{{ route('owner.properties.create') }}" 
                       class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden block">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
                        <div class="relative z-10 text-center">
                            <i class="fas fa-plus text-2xl mb-2 block"></i>
                            <span class="font-semibold">Add Property</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.appointments.index') }}" 
                       class="group relative bg-white border border-[#CBA660] text-[#CBA660] p-4 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 transform hover:scale-105 block">
                        <div class="text-center">
                            <i class="fas fa-calendar text-2xl mb-2 block"></i>
                            <span class="font-semibold">View Calendar</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.properties.index') }}" 
                       class="group relative bg-white border border-[#CBA660] text-[#CBA660] p-4 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 transform hover:scale-105 block">
                        <div class="text-center">
                            <i class="fas fa-building text-2xl mb-2 block"></i>
                            <span class="font-semibold">Manage Properties</span>
                        </div>
                    </a>
                </div>
            </div>

            
        </div>
    </div>

    @if($propertyStats['total'] == 0)
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-4xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold mb-4">Welcome to Your Property Owner Dashboard</h3>
                <p class="text-white/80 text-lg mb-6 max-w-2xl mx-auto">
                    Start your real estate journey with ChriWBi3. Add your first property and begin connecting with potential clients.
                </p>
                <a href="{{ route('owner.properties.create') }}" 
                   class="inline-flex items-center bg-white text-[#2F2B40] font-semibold px-8 py-4 rounded-xl hover:bg-white/90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Add Your First Property
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Update appointment status
function updateAppointmentStatus(appointmentId, status) {
    const action = status === 'confirmed' ? 'approve' : 'reject';

    if (!confirm(`Are you sure you want to ${action} this appointment?`)) {
        return;
    }

    fetch(`/owner/appointments/${appointmentId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: status,
            response: status === 'confirmed' ? 'Appointment confirmed' : 'Appointment rejected'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message with ChriWBi3 styling
            const message = document.createElement('div');
            message.className = 'fixed top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50 transform transition-all duration-300';
            message.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-medium">${data.message}</span>
                </div>
            `;
            document.body.appendChild(message);

            // Animate in
            setTimeout(() => {
                message.style.transform = 'translateX(0)';
            }, 100);

            // Remove message after 3 seconds
            setTimeout(() => {
                message.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    message.remove();
                }, 300);
            }, 3000);

            // Reload page to update the UI
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            // Show error message with ChriWBi3 styling
            const message = document.createElement('div');
            message.className = 'fixed top-4 right-4 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50';
            message.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                    <span class="font-medium">${data.message || 'Error updating appointment status'}</span>
                </div>
            `;
            document.body.appendChild(message);

            // Remove message after 3 seconds
            setTimeout(() => {
                message.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Show error message with ChriWBi3 styling
        const message = document.createElement('div');
        message.className = 'fixed top-4 right-4 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50';
        message.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <span class="font-medium">Error updating appointment status</span>
            </div>
        `;
        document.body.appendChild(message);

        // Remove message after 3 seconds
        setTimeout(() => {
            message.remove();
        }, 3000);
    });
}
</script>
@endpush
@endsection