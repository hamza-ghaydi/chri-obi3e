@extends('layouts.dashboard')

@section('title', 'Appointments - Owner Dashboard')
@section('page-title', 'Property Appointments')

@section('content')
    <div class="space-y-8">
        
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Property Appointments</h2>
                    <p class="text-white/80 text-lg">Manage property viewing appointments and schedules</p>
                </div>
                <div class="flex space-x-3">
                    
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Appointments Calendar</h3>
                        <p class="text-gray-600">View and manage your appointment schedule</p>
                    </div>
                    <div class="flex space-x-3">
                        <button id="prev-btn"
                            class="bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] hover:text-[#CBA660] transition-all duration-300">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button id="next-btn"
                            class="bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] hover:text-[#CBA660] transition-all duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button id="today-btn"
                            class="bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] hover:text-[#CBA660] transition-all duration-300">
                            Today
                        </button>
                        <select id="view-selector"
                            class="bg-white border border-gray-300 rounded-xl px-7 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                            <option value="dayGridMonth">Month</option>
                            <option value="timeGridWeek">Week</option>
                            <option value="timeGridDay">Day</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="calendar" class="p-6" style="min-height: 500px;">
                <div id="calendar-loading" class="text-center py-12">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spinner fa-spin text-2xl text-[#CBA660]"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Loading calendar...</p>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Recent Appointment Requests</h3>
                        <p class="text-gray-600">Manage incoming appointment requests</p>
                    </div>
                    <div class="flex space-x-3">
                        <select id="status-filter"
                            class="bg-white border border-gray-300 rounded-xl px-7 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <select id="property-filter"
                            class="bg-white border border-gray-300 rounded-xl px-7 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                            <option value="">All Properties</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}">{{ Str::limit($property->title, 30) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="appointments-list" class="p-6">
                <div class="text-center py-12">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-3xl text-[#CBA660]"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Loading appointments...</p>
                </div>
            </div>
        </div>

        <!-- Calendar Integration -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Calendar Integration</h3>
                <p class="text-gray-600">Configure your availability and appointment settings</p>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <h4 class="text-xl font-semibold text-[#2F2B40] mb-4">Availability Settings</h4>
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-6">
                            <label class="block text-sm font-medium text-[#2F2B40] mb-4">Available Days</label>
                            <div class="space-y-3">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Monday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Tuesday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Wednesday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Thursday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Friday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox"
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Saturday</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox"
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span
                                        class="ml-3 text-sm text-gray-700 group-hover:text-[#2F2B40] transition-colors">Sunday</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-xl font-semibold text-[#2F2B40] mb-4">Time Slots</h4>
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-[#2F2B40] mb-3">Available Hours</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="time" value="09:00"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-[#CBA660] focus:border-[#CBA660] transition-all duration-300">
                                    <input type="time" value="18:00"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-[#CBA660] focus:border-[#CBA660] transition-all duration-300">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#2F2B40] mb-3">Appointment Duration</label>
                                <select
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-[#CBA660] focus:border-[#CBA660] transition-all duration-300">
                                    <option>30 minutes</option>
                                    <option>45 minutes</option>
                                    <option>60 minutes</option>
                                    <option>90 minutes</option>
                                </select>
                            </div>

                            <button
                                class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointment-modal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-[#2F2B40]">Appointment Details</h3>
                        <button id="close-modal"
                            class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-700 transition-all duration-300">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <div id="modal-content" class="space-y-4">
                        <!-- Content will be populated by JavaScript -->
                    </div>

                    <div id="modal-actions" class="flex space-x-3 mt-6">
                        <!-- Action buttons will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
        <style>
            .fc-event {
                border-radius: 8px;
                border: none !important;
                padding: 4px 8px;
                font-weight: 500;
            }

            .fc-event-title {
                font-weight: 600;
            }

            .fc-daygrid-event {
                margin: 2px 0;
            }

            .fc-toolbar {
                margin-bottom: 1.5rem;
            }

            .fc-toolbar-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #2F2B40;
            }

            .fc-button-primary {
                background: linear-gradient(135deg, #CBA660, #CBA660dd) !important;
                border: none !important;
                color: white !important;
                border-radius: 12px !important;
                font-weight: 600 !important;
                padding: 8px 16px !important;
                transition: all 0.3s ease !important;
            }

            .fc-button-primary:hover {
                background: linear-gradient(135deg, #CBA660dd, #CBA660bb) !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px rgba(203, 166, 96, 0.3) !important;
            }

            .fc-button-primary:disabled {
                background: #e5e7eb !important;
                color: #9ca3af !important;
                transform: none !important;
                box-shadow: none !important;
            }

            .fc-today-button,
            .fc-prev-button,
            .fc-next-button {
                font-size: 14px !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, initializing calendar...');

                const calendarEl = document.getElementById('calendar');
                const loadingEl = document.getElementById('calendar-loading');

                if (!calendarEl) {
                    console.error('Calendar element not found!');
                    return;
                }

                console.log('Calendar element found:', calendarEl);

                try {
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: false,
                        height: 'auto',
                        events: function(fetchInfo, successCallback, failureCallback) {
                            console.log('Fetching events...');

                            fetch('{{ route('owner.appointments.data') }}')
                                .then(response => {
                                    console.log('Response received:', response);
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Events data:', data);
                                    successCallback(data);
                                })
                                .catch(error => {
                                    console.error('Error fetching events:', error);
                                    if (loadingEl) {
                                        loadingEl.innerHTML = `
                                            <div class="text-center py-12">
                                                <div class="w-16 h-16 bg-gradient-to-br from-red-500/20 to-red-500/40 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                                                </div>
                                                <p class="text-red-500 font-medium">Error loading appointments</p>
                                            </div>
                                        `;
                                    }
                                    failureCallback(error);
                                });
                        },
                        eventClick: function(info) {
                            console.log('Event clicked:', info.event);
                            showAppointmentModal(info.event);
                        },
                        eventDidMount: function(info) {
                            info.el.setAttribute('title',
                                info.event.extendedProps.client_name + ' - ' +
                                info.event.extendedProps.property_title
                            );
                        }
                    });

                    console.log('Rendering calendar...');
                    calendar.render();
                    console.log('Calendar rendered successfully');

                    // Custom toolbar controls
                    const prevBtn = document.getElementById('prev-btn');
                    const nextBtn = document.getElementById('next-btn');
                    const todayBtn = document.getElementById('today-btn');
                    const viewSelector = document.getElementById('view-selector');
                    const refreshBtn = document.getElementById('refresh-calendar');

                    if (prevBtn) {
                        prevBtn.addEventListener('click', function() {
                            calendar.prev();
                        });
                    }

                    if (nextBtn) {
                        nextBtn.addEventListener('click', function() {
                            calendar.next();
                        });
                    }

                    if (todayBtn) {
                        todayBtn.addEventListener('click', function() {
                            calendar.today();
                        });
                    }

                    if (viewSelector) {
                        viewSelector.addEventListener('change', function() {
                            calendar.changeView(this.value);
                        });
                    }

                    if (refreshBtn) {
                        refreshBtn.addEventListener('click', function() {
                            calendar.refetchEvents();
                        });
                    }

                } catch (error) {
                    console.error('Error initializing calendar:', error);
                    if (loadingEl) {
                        loadingEl.innerHTML = `
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gradient-to-br from-red-500/20 to-red-500/40 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                                </div>
                                <p class="text-red-500 font-medium">Error initializing calendar</p>
                            </div>
                        `;
                    }
                }

                function showAppointmentModal(event) {
                    console.log('📋 Showing modal for event:', event);

                    const modal = document.getElementById('appointment-modal');
                    const content = document.getElementById('modal-content');
                    const actions = document.getElementById('modal-actions');

                    if (!modal || !content || !actions) {
                        console.error('❌ Modal elements not found');
                        const props = event.extendedProps;
                        alert(`Appointment Details:

Client: ${props.client_name || 'Unknown'}
Property: ${props.property_title || 'Unknown'}
Status: ${props.status || 'Unknown'}
Date: ${event.start ? event.start.toLocaleDateString() : 'Unknown'}
Message: ${props.message || 'No message'}`);
                        return;
                    }

                    const props = event.extendedProps || {};
                    const clientName = props.client_name || 'Unknown';
                    const propertyTitle = props.property_title || 'Unknown';
                    const status = props.status || 'Unknown';
                    const message = props.message || 'No message';

                    let formattedDate = 'Unknown';
                    if (event.start) {
                        try {
                            formattedDate = event.start.toLocaleDateString();
                        } catch (error) {
                            formattedDate = 'Invalid Date';
                        }
                    }

                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-comment text-[#CBA660] mr-3"></i>
                                    <span class="font-semibold text-[#2F2B40]">Message:</span>
                                </div>
                                <span class="text-gray-700">${escapeHtml(message)}</span>
                            </div>
                        </div>
                    `;

                    actions.innerHTML = `
                        <button onclick="closeModal()" class="w-full bg-white border border-[#CBA660] text-[#CBA660] font-semibold py-3 px-6 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300">
                            <i class="fas fa-times mr-2"></i>Close
                        </button>
                    `;

                    modal.classList.remove('hidden');
                }

                // Close modal function
                window.closeModal = function() {
                    const modal = document.getElementById('appointment-modal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }

                // Close modal when clicking outside
                document.getElementById('appointment-modal')?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });

                // Close modal with escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeModal();
                    }
                });

                // Helper function to escape HTML
                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Load appointments list
                function loadAppointmentsList() {
                    const listContainer = document.getElementById('appointments-list');

                    fetch('{{ route('owner.appointments.data') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                listContainer.innerHTML = `
                                    <div class="text-center py-12">
                                        <div class="w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <i class="fas fa-calendar-alt text-3xl text-[#CBA660]"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-[#2F2B40] mb-2">No Appointments Found</h3>
                                        <p class="text-gray-600">You don't have any appointments scheduled yet.</p>
                                    </div>
                                `;
                                return;
                            }

                            const appointmentsHtml = data.map(appointment => {
                                const statusColor = appointment.backgroundColor;
                                const statusText = appointment.extendedProps.status;

                                // Status colors mapping
                                let statusBg = 'bg-gray-100';
                                let statusTextColor = 'text-gray-700';

                                if (statusText === 'confirmed') {
                                    statusBg = 'bg-green-100';
                                    statusTextColor = 'text-green-700';
                                } else if (statusText === 'pending') {
                                    statusBg = 'bg-yellow-100';
                                    statusTextColor = 'text-yellow-700';
                                } else if (statusText === 'rejected') {
                                    statusBg = 'bg-red-100';
                                    statusTextColor = 'text-red-700';
                                }

                                return `
                                    <div class="group flex items-center justify-between p-6 border-b border-gray-100 hover:bg-gradient-to-r hover:from-[#2F2B40]/5 hover:to-[#CBA660]/5 transition-all duration-300 rounded-xl">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-4 h-4 rounded-full shadow-lg" style="background-color: ${statusColor}"></div>
                                            <div>
                                                <div class="font-semibold text-[#2F2B40] text-lg group-hover:text-[#CBA660] transition-colors duration-300">
                                                    ${appointment.extendedProps.client_name}
                                                </div>
                                                <div class="text-gray-600 font-medium">
                                                    ${appointment.extendedProps.property_title}
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                                    <i class="fas fa-calendar-alt mr-2 text-[#CBA660]"></i>
                                                    ${new Date(appointment.start).toLocaleDateString()} at ${new Date(appointment.start).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusBg} ${statusTextColor}">
                                                ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}
                                            </span>
                                            <button onclick="showAppointmentDetails('${appointment.id}')" class="w-10 h-10 bg-white border border-[#CBA660] text-[#CBA660] rounded-xl hover:bg-[#CBA660] hover:text-white transition-all duration-300 flex items-center justify-center group-hover:scale-110 transform">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                            }).join('');

                            listContainer.innerHTML = `<div class="space-y-2">${appointmentsHtml}</div>`;
                        })
                        .catch(error => {
                            console.error('Error loading appointments list:', error);
                            listContainer.innerHTML = `
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-br from-red-500/20 to-red-500/40 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-red-600 mb-2">Error Loading Appointments</h3>
                                    <p class="text-gray-600">Please try refreshing the page.</p>
                                </div>
                            `;
                        });
                }

                // Show appointment details
                window.showAppointmentDetails = function(appointmentId) {
                    const events = calendar.getEvents();
                    const event = events.find(e => e.id == appointmentId);
                    if (event) {
                        showAppointmentModal(event);
                    }
                }

                // Load appointments list on page load
                loadAppointmentsList();

                // Filter functionality
                const statusFilter = document.getElementById('status-filter');
                const propertyFilter = document.getElementById('property-filter');

                if (statusFilter) {
                    statusFilter.addEventListener('change', function() {
                        // Implement filtering logic here
                        loadAppointmentsList();
                    });
                }

                if (propertyFilter) {
                    propertyFilter.addEventListener('change', function() {
                        // Implement filtering logic here
                        loadAppointmentsList();
                    });
                }
            });
        </script>
    @endpush
@endsection
