@extends('layouts.app')

@section('title', 'Schedule Visit - ' . $property->title)

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
                <span>Schedule Visit</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Schedule Property Visit</h1>
            <p class="text-gray-600">Choose your preferred date and time to visit this property</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Calendar and Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-brand-dark mb-6">Select Date & Time</h2>
                    
                    <!-- Calendar -->
                    <div id="calendar" class="mb-6"></div>
                    
                    <!-- Appointment Form -->
                    <form id="appointment-form" action="{{ route('appointments.store', $property) }}" method="POST" class="space-y-6" style="display: none;">
                        @csrf
                        
                        <input type="hidden" id="appointment_date" name="appointment_date" value="">
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-check text-blue-500 mr-3"></i>
                                <div>
                                    <p class="font-semibold text-blue-800">Selected Date & Time:</p>
                                    <p id="selected-datetime" class="text-blue-700"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                            <textarea name="client_message" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent"
                                      placeholder="Any specific requirements or questions about the visit...">{{ old('client_message') }}</textarea>
                            @error('client_message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-500 mt-1 mr-3"></i>
                                <div class="text-sm text-yellow-700">
                                    <p class="font-semibold mb-1">Important Notes:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Your appointment request will be sent to the property owner</li>
                                        <li>The owner will confirm or suggest alternative times</li>
                                        <li>You'll receive an email notification with the status</li>
                                        <li>Please arrive on time for your scheduled visit</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-brand-dark text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 font-semibold">
                                <i class="fas fa-calendar-plus mr-2"></i>Request Appointment
                            </button>
                            
                            <button type="button" onclick="resetSelection()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-semibold">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                    
                    <!-- Instructions -->
                    <div id="calendar-instructions" class="text-center text-gray-600 mt-6">
                        <i class="fas fa-hand-pointer text-4xl mb-3 block text-gray-400"></i>
                        <p class="text-lg font-semibold mb-2">Click on a date to schedule your visit</p>
                        <p class="text-sm">Available time slots will be shown for your selected date</p>
                    </div>
                </div>
            </div>

            <!-- Property Summary & Info -->
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
                    </div>
                </div>

                <!-- Visit Guidelines -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">
                        <i class="fas fa-clipboard-list mr-2"></i>Visit Guidelines
                    </h3>
                    
                    <ul class="text-sm text-green-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Arrive on time for your scheduled appointment
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Bring a valid ID for verification
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Prepare questions about the property
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Respect the property and owner's time
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mr-2 mt-1 text-green-600"></i>
                            Contact owner if you need to reschedule
                        </li>
                    </ul>
                </div>

                <!-- Process Steps -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">
                        <i class="fas fa-route mr-2"></i>Next Steps
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 1: Contact Owner - Completed</span>
                        </div>
                        <div class="flex items-center text-blue-700 font-semibold">
                            <i class="fas fa-clock mr-2"></i>
                            <span>→ Step 2: Schedule Visit - In Progress</span>
                        </div>
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-circle mr-2"></i>
                            <span>Step 3: Complete Payment - Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const appointmentForm = document.getElementById('appointment-form');
    const instructions = document.getElementById('calendar-instructions');
    const selectedDatetime = document.getElementById('selected-datetime');
    const appointmentDateInput = document.getElementById('appointment_date');

    // Existing appointments data
    const existingAppointments = @json($existingAppointments);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        
        // Disable past dates
        validRange: {
            start: new Date().toISOString().split('T')[0]
        },
        
        // Handle date selection
        select: function(info) {
            showTimeSlots(info.startStr);
        },
        
        // Show existing appointments
        events: existingAppointments.map(appointment => ({
            title: appointment.status === 'confirmed' ? 'Confirmed Visit' : 'Pending Visit',
            start: appointment.appointment_date,
            color: appointment.status === 'confirmed' ? '#dc2626' : '#f59e0b',
            display: 'block'
        })),
        
        // Customize day rendering
        dayCellDidMount: function(info) {
            // Highlight today
            if (info.date.toDateString() === new Date().toDateString()) {
                info.el.style.backgroundColor = '#fef3c7';
            }
        }
    });

    calendar.render();

    function showTimeSlots(dateStr) {
        const timeSlots = [
            '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'
        ];

        const slotsHtml = timeSlots.map(time => {
            const datetime = `${dateStr} ${time}:00`;
            const isBooked = existingAppointments.some(apt => 
                apt.appointment_date.startsWith(datetime.substring(0, 16))
            );
            
            return `
                <button type="button" 
                        onclick="selectTimeSlot('${datetime}')" 
                        class="time-slot ${isBooked ? 'booked' : 'available'}"
                        ${isBooked ? 'disabled' : ''}>
                    ${time}
                    ${isBooked ? '<span class="text-xs block">(Booked)</span>' : ''}
                </button>
            `;
        }).join('');

        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">Select Time for ${new Date(dateStr).toLocaleDateString()}</h3>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    ${slotsHtml}
                </div>
                <button onclick="this.closest('.fixed').remove()" 
                        class="w-full bg-gray-300 text-gray-700 py-2 rounded hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        `;
        
        document.body.appendChild(modal);
    }

    window.selectTimeSlot = function(datetime) {
        appointmentDateInput.value = datetime;
        selectedDatetime.textContent = new Date(datetime).toLocaleString();
        
        // Show form, hide instructions
        appointmentForm.style.display = 'block';
        instructions.style.display = 'none';
        
        // Close modal
        document.querySelector('.fixed').remove();
        
        // Scroll to form
        appointmentForm.scrollIntoView({ behavior: 'smooth' });
    };

    window.resetSelection = function() {
        appointmentForm.style.display = 'none';
        instructions.style.display = 'block';
        appointmentDateInput.value = '';
        selectedDatetime.textContent = '';
    };
});
</script>

<style>
.time-slot {
    @apply px-4 py-3 rounded-lg border text-sm font-medium transition-colors;
}

.time-slot.available {
    @apply border-green-300 text-green-700 bg-green-50 hover:bg-green-100;
}

.time-slot.booked {
    @apply border-red-300 text-red-700 bg-red-50 cursor-not-allowed opacity-60;
}

.fc-event {
    font-size: 12px !important;
}

.fc-daygrid-event {
    margin: 1px !important;
}
</style>
@endsection
