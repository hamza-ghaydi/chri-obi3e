@extends('layouts.main')

@section('title', 'Schedule Visit - ' . $property->title)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8">

                <div
                    class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16">
                    </div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12">
                    </div>

                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-3">Schedule Property Visit</h1>
                            <p class="text-white/80 text-lg">Choose your preferred date and time to visit this amazing
                                property</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-calendar-check text-6xl text-[#CBA660]/30"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 mb-8 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800 text-lg">Success!</h3>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-[#2F2B40] mb-2">Select Date & Time</h2>
                                    <p class="text-gray-600">Choose when you'd like to visit the property</p>
                                </div>
                                <i class="fas fa-calendar text-2xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8">
                            {{-- Calendar  --}}
                            <div id="calendar"
                                class="mb-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"></div>


                            <form id="appointment-form" action="{{ route('appointments.store', $property) }}" method="POST"
                                class="space-y-6" style="display: none;">
                                @csrf

                                <input type="hidden" id="appointment_date" name="appointment_date" value="">

                                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-6 rounded-2xl border ">
                                    <div class="flex items-center">

                                        <div>
                                            <p class="font-bold text-[#2F2B40] text-lg">Selected Date & Time:</p>
                                            <p id="selected-datetime" class="text-[#2F2B40]/50 font-medium"></p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-[#2F2B40] mb-3">Additional Notes
                                        (Optional)</label>
                                    <textarea name="client_message" rows="4"
                                        class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660] focus:border-transparent transition-all duration-300 resize-none"
                                        placeholder="Any specific requirements or questions about the visit...">{{ old('client_message') }}</textarea>
                                    @error('client_message')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>



                                <div class="flex space-x-4">
                                    <button type="submit"
                                        class="flex-1 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-4 px-6 rounded-xl hover:shadow-lg transition-all duration-300 font-bold text-lg transform hover:scale-105">
                                        <i class="fas fa-calendar-plus mr-3"></i>Request Appointment
                                    </button>

                                    <button type="button" onclick="resetSelection()"
                                        class="px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-bold transform hover:scale-105">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </button>
                                </div>
                            </form>


                            <div id="calendar-instructions" class="text-center py-12">

                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-3">Click on a date to schedule your visit
                                </h3>
                                <p class="text-gray-600 text-lg">Available time slots will be shown for your selected date
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="space-y-8">
                    <!-- Property Card -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
                        <div class="relative">
                            <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}"
                                class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#2F2B40] mb-4">{{ $property->title }}</h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-[#CBA660]"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $property->address }},
                                        {{ $property->city->name }}</span>
                                </div>

                                <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-[#CBA660]"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $property->category->name }}</span>
                                </div>

                                <div
                                    class="flex items-center bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660] rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                    </div>
                                    <span class="text-[#CBA660] font-bold text-lg">{{ $property->formatted_price }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-xl text-center">
                                    <div class="text-2xl font-bold text-[#2F2B40]">{{ $property->bedrooms }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Bedrooms</div>
                                </div>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-xl text-center">
                                    <div class="text-2xl font-bold text-[#2F2B40]">{{ $property->bathrooms }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Bathrooms</div>
                                </div>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-xl text-center">
                                    <div class="text-2xl font-bold text-[#2F2B40]">{{ number_format($property->area) }}
                                    </div>
                                    <div class="text-sm text-gray-600 font-medium">m²</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Info -->
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40]">Property Owner</h3>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-6">
                                <div>
                                    <div class="text-lg font-bold text-[#2F2B40]">{{ $property->owner->name }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Property Owner</div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-[#CBA660]"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $property->owner->email }}</span>
                                </div>

                                @if ($property->owner->phone)
                                    <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                        <div
                                            class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-phone text-[#CBA660]"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $property->owner->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    {{-- Process Steps --}}
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-[#CBA660]/20 px-6 py-4">
                            <h3 class="text-xl font-bold text-[#CBA660] flex items-center">
                                <i class="fas fa-route mr-3"></i>Next Steps
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center p-4">

                                    <span class="text-[#CBA660] font-bold">✓ Step 1: Contact Owner - Completed</span>
                                </div>
                                <div class="flex items-center  p-4">

                                    <span class="text-[#2F2B40] font-bold">→ Step 2: Schedule Visit - In Progress</span>
                                </div>
                                <div class="flex items-center p-4">

                                    <span class="text-[#2F2B40] font-bold">→ Step 3: Continue with Owner</span>
                                </div>
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

                // Modern styling
                themeSystem: 'bootstrap5',

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
                    title: appointment.status === 'confirmed' ? 'Confirmed Visit' :
                        'Pending Visit',
                    start: appointment.appointment_date,
                    color: appointment.status === 'confirmed' ? '#dc2626' : '#f59e0b',
                    display: 'block'
                })),

                // Customize day rendering
                dayCellDidMount: function(info) {
                    // Highlight today
                    if (info.date.toDateString() === new Date().toDateString()) {
                        info.el.style.backgroundColor = '#fef3c7';
                        info.el.style.borderRadius = '8px';
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
                    <div class="text-lg font-bold">${time}</div>
                    ${isBooked ? '<div class="text-xs text-[#2F2B40] font-medium">Booked</div>' : '<div class="text-xs text-[#CBA660] font-medium">Available</div>'}
                </button>
            `;
                }).join('');

                const modal = document.createElement('div');
                modal.className =
                    'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40] to-[#CBA660] p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Select Time</h3>
                    <p class="text-white/80">${new Date(dateStr).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        ${slotsHtml}
                    </div>
                    <button onclick="this.closest('.fixed').remove()" 
                            class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-300 transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                </div>
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
                appointmentForm.scrollIntoView({
                    behavior: 'smooth'
                });
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
            @apply px-4 py-4 rounded-xl border-2 text-sm font-medium transition-all duration-300 transform hover:scale-105;
        }

        .time-slot.available {
            @apply border-green-300 text-green-700 bg-gradient-to-br from-green-50 to-green-100 hover:bg-green-200 hover:shadow-lg;
        }

        .time-slot.booked {
            @apply border-red-300 text-red-700 bg-gradient-to-br from-red-50 to-red-100 cursor-not-allowed opacity-60;
        }

        /* Calendar customization */
        .fc {
            font-family: inherit;
        }

        .fc-event {
            font-size: 12px !important;
            border-radius: 8px !important;
            border: none !important;
            padding: 2px 4px !important;
        }

        .fc-daygrid-event {
            margin: 2px !important;
        }

        .fc-button-primary {
            background-color: #CBA660 !important;
            border-color: #CBA660 !important;
        }

        .fc-button-primary:hover {
            background-color: #b8954d !important;
            border-color: #b8954d !important;
        }

        .fc-today-button {
            background-color: #2F2B40 !important;
            border-color: #2F2B40 !important;
        }
    </style>
@endsection
