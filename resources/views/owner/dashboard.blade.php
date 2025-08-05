@extends('layouts.dashboard')

@section('title', 'Owner Dashboard - Real Estate Platform')
@section('page-title', 'Property Owner Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $propertyStats['total'] }}</div>
                    <div class="dashboard-stat-label">Total Properties</div>
                </div>
                <div class="text-brand-beige">
                    <i class="fas fa-building text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $propertyStats['published'] }}</div>
                    <div class="dashboard-stat-label">Published Properties</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $appointmentStats['pending'] }}</div>
                    <div class="dashboard-stat-label">Pending Appointments</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $appointmentStats['total'] }}</div>
                    <div class="dashboard-stat-label">Total Appointments</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-calendar text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointment Requests -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Recent Appointment Requests</h3>
                    <a href="{{ route('owner.appointments.index') }}" class="text-brand-beige hover:text-brand-dark text-sm">
                        View All
                    </a>
                </div>

                @if($recentAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-brand-beige rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-brand-dark"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-brand-dark">{{ $appointment->client->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $appointment->property->title }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $appointment->appointment_date->format('M d, Y - H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>

                                    @if($appointment->status === 'pending')
                                        <div class="flex space-x-2">
                                            <button onclick="updateAppointmentStatus({{ $appointment->id }}, 'confirmed')"
                                                    class="text-green-600 hover:text-green-800 text-sm px-2 py-1 rounded border border-green-300 hover:bg-green-50">
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>
                                            <button onclick="updateAppointmentStatus({{ $appointment->id }}, 'rejected')"
                                                    class="text-red-600 hover:text-red-800 text-sm px-2 py-1 rounded border border-red-300 hover:bg-red-50">
                                                <i class="fas fa-times mr-1"></i>Reject
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar text-4xl mb-3 block"></i>
                        <p>No appointment requests yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions Sidebar -->
        <div class="space-y-6">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Quick Actions</h3>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('owner.properties.create') }}" class="btn-primary w-full text-center">
                        <i class="fas fa-plus mr-2"></i>Add Property
                    </a>

                    <a href="{{ route('owner.appointments.index') }}" class="btn-outline w-full text-center">
                        <i class="fas fa-calendar mr-2"></i>View Calendar
                    </a>

                    <a href="{{ route('owner.properties.index') }}" class="btn-outline w-full text-center">
                        <i class="fas fa-building mr-2"></i>Manage Properties
                    </a>
                </div>
            </div>

            <!-- Appointment Stats -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Appointment Status</h3>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pending:</span>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm font-semibold">
                            {{ $appointmentStats['pending'] }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Confirmed:</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-semibold">
                            {{ $appointmentStats['confirmed'] }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Rejected:</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm font-semibold">
                            {{ $appointmentStats['rejected'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($propertyStats['total'] == 0)
        <!-- Welcome Message -->
        <div class="dashboard-card">
            <div class="text-center py-8">
                <i class="fas fa-home text-6xl text-brand-beige mb-4"></i>
                <h3 class="text-2xl font-semibold text-brand-dark mb-4">Welcome to Your Property Owner Dashboard</h3>
                <p class="text-gray-600 mb-6">Start by adding your first property to begin earning with our platform.</p>
                <a href="{{ route('owner.properties.create') }}" class="btn-primary">
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
            // Show success message
            const message = document.createElement('div');
            message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            message.textContent = data.message;
            document.body.appendChild(message);

            // Remove message after 3 seconds
            setTimeout(() => {
                message.remove();
            }, 3000);

            // Reload page to update the UI
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert(data.message || 'Error updating appointment status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating appointment status');
    });
}
</script>
@endpush
@endsection
