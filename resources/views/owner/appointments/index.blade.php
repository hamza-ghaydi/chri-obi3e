@extends('layouts.dashboard')

@section('title', 'Appointments - Owner Dashboard')
@section('page-title', 'Property Appointments')

@section('breadcrumb')
    <a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
    <span class="mx-2">/</span>
    <span>Appointments</span>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600">Manage property viewing appointments</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('owner.dashboard') }}" class="btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                <button id="refresh-calendar" class="btn-primary">
                    <i class="fas fa-sync mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="dashboard-stat">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="dashboard-stat-value">{{ $stats['total'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Total Appointments</div>
                    </div>
                    <div class="text-blue-500">
                        <i class="fas fa-calendar text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-stat">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="dashboard-stat-value">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Pending Requests</div>
                    </div>
                    <div class="text-yellow-500">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-stat">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="dashboard-stat-value">{{ $stats['confirmed'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Confirmed</div>
                    </div>
                    <div class="text-green-500">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-stat">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="dashboard-stat-value">{{ $stats['this_week'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">This Week</div>
                    </div>
                    <div class="text-purple-500">
                        <i class="fas fa-calendar-week text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Appointments Calendar</h3>
                <div class="flex space-x-2">
                    <button id="prev-btn" class="btn-outline text-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="next-btn" class="btn-outline text-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button id="today-btn" class="btn-outline text-sm">Today</button>
                    <select id="view-selector" class="form-input text-sm">
                        <option value="dayGridMonth">Month</option>
                        <option value="timeGridWeek">Week</option>
                        <option value="timeGridDay">Day</option>
                    </select>
                </div>
            </div>

            <div id="calendar" class="p-4" style="min-height: 500px;">
                <div id="calendar-loading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-3xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500">Loading calendar...</p>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Recent Appointment Requests</h3>
                <div class="flex space-x-2">
                    <select id="status-filter" class="form-input text-sm">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <select id="property-filter" class="form-input text-sm">
                        <option value="">All Properties</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ Str::limit($property->title, 30) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="appointments-list">
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar-alt text-4xl mb-3 block"></i>
                    <p>Loading appointments...</p>
                </div>
            </div>
        </div>

        <!-- Calendar Integration -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Calendar Integration</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-brand-dark mb-3">Availability Settings</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="form-label">Available Days</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2">
                                    <span class="text-sm">Monday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2">
                                    <span class="text-sm">Tuesday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2">
                                    <span class="text-sm">Wednesday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2">
                                    <span class="text-sm">Thursday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2">
                                    <span class="text-sm">Friday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span class="text-sm">Saturday</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span class="text-sm">Sunday</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-brand-dark mb-3">Time Slots</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="form-label">Available Hours</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="time" value="09:00" class="form-input text-sm">
                                <input type="time" value="18:00" class="form-input text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Appointment Duration</label>
                            <select class="form-input">
                                <option>30 minutes</option>
                                <option>45 minutes</option>
                                <option>60 minutes</option>
                                <option>90 minutes</option>
                            </select>
                        </div>

                        <button class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-brand-dark">Appointment Details</h3>
                        <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div id="modal-content">
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
                border-radius: 4px;
                border: none !important;
                padding: 2px 4px;
            }

            .fc-event-title {
                font-weight: 500;
            }

            .fc-daygrid-event {
                margin: 1px 0;
            }

            .fc-toolbar {
                margin-bottom: 1rem;
            }

            .fc-toolbar-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #251605;
            }

            .fc-button-primary {
                background-color: #F7DBA7 !important;
                border-color: #F7DBA7 !important;
                color: #251605 !important;
            }

            .fc-button-primary:hover {
                background-color: #f5d085 !important;
                border-color: #f5d085 !important;
            }

            .fc-button-primary:disabled {
                background-color: #e5e7eb !important;
                border-color: #e5e7eb !important;
                color: #9ca3af !important;
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
                                    // if (loadingEl) {
                                    //     loadingEl.style.display = 'none';
                                    // }
                                    successCallback(data);
                                })
                                .catch(error => {
                                    console.error('Error fetching events:', error);
                                    if (loadingEl) {
                                        loadingEl.innerHTML =
                                            '<p class="text-red-500">Error loading appointments</p>';
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

                    // if (loadingEl) {
                    //     loadingEl.style.display = 'none';
                    // }

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
                        loadingEl.innerHTML = '<p class="text-red-500">Error initializing calendar</p>';
                    }
                }

                // Modal functionality
                //                 function showAppointmentModal(event) {
                //                     console.log('Showing modal for event:', event);

                //                     const props = event.extendedProps;

                //                     // Simple alert for now - can be enhanced later
                //                     alert(`Appointment Details:

        // Client: ${props.client_name || 'Unknown'}
        // Property: ${props.property_title || 'Unknown'}
        // Status: ${props.status || 'Unknown'}
        // Date: ${event.start ? event.start.toLocaleDateString() : 'Unknown'}
        // Message: ${props.message || 'No message'}`);
                //                 }


                function showAppointmentModal(event) {
                    console.log('📋 Showing modal for event:', event);

                    const modal = document.getElementById('appointment-modal');
                    const content = document.getElementById('modal-content');
                    const actions = document.getElementById('modal-actions');

                    // Check if modal elements exist
                    if (!modal || !content || !actions) {
                        console.error('❌ Modal elements not found');
                        // Fallback to alert if modal doesn't exist
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

                    // Get the info with safe defaults
                    const clientName = props.client_name || 'Unknown';
                    const propertyTitle = props.property_title || 'Unknown';
                    const status = props.status || 'Unknown';
                    const message = props.message || 'No message';

                    // Format date safely
                    let formattedDate = 'Unknown';
                    if (event.start) {
                        try {
                            formattedDate = event.start.toLocaleDateString();
                        } catch (error) {
                            formattedDate = 'Invalid Date';
                        }
                    }

                    // Simple content - just the info from the alert
                    content.innerHTML = `
        <div class="space-y-3">
            <div>
                <strong>Client:</strong> ${escapeHtml(clientName)}
            </div>
            <div>
                <strong>Property:</strong> ${escapeHtml(propertyTitle)}
            </div>
            <div>
                <strong>Status:</strong> ${escapeHtml(status)}
            </div>
            <div>
                <strong>Date:</strong> ${escapeHtml(formattedDate)}
            </div>
            <div>
                <strong>Message:</strong> ${escapeHtml(message)}
            </div>
        </div>
    `;

                    // Just a close button
                    actions.innerHTML = `
        <button onclick="closeModal()" class="btn-outline w-full">
            Close
        </button>
    `;

                    // Show modal
                    modal.classList.remove('hidden');
                }

                // Simple close function
                function closeModal() {
                    const modal = document.getElementById('appointment-modal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }

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
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-calendar-alt text-4xl mb-3 block"></i>
                            <p>No appointments found</p>
                        </div>
                    `;
                                return;
                            }

                            const appointmentsHtml = data.map(appointment => {
                                const statusColor = appointment.backgroundColor;
                                const statusText = appointment.extendedProps.status;

                                return `
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-3 h-3 rounded-full" style="background-color: ${statusColor}"></div>
                                <div>
                                    <div class="font-semibold text-brand-dark">${appointment.extendedProps.client_name}</div>
                                    <div class="text-sm text-gray-600">${appointment.extendedProps.property_title}</div>
                                    <div class="text-xs text-gray-500">${new Date(appointment.start).toLocaleDateString()} at ${new Date(appointment.start).toLocaleTimeString()}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background-color: ${statusColor}20; color: ${statusColor}">
                                    ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}
                                </span>
                                <button onclick="showAppointmentDetails('${appointment.id}')" class="text-brand-beige hover:text-brand-dark">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    `;
                            }).join('');

                            listContainer.innerHTML = appointmentsHtml;
                        })
                        .catch(error => {
                            console.error('Error loading appointments list:', error);
                            listContainer.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3 block"></i>
                        <p>Error loading appointments</p>
                    </div>
                `;
                        });
                }

                // Show appointment details
                function showAppointmentDetails(appointmentId) {
                    // Find the appointment in the calendar events
                    const events = calendar.getEvents();
                    const event = events.find(e => e.id == appointmentId);
                    if (event) {
                        showAppointmentModal(event);
                    }
                }

                // Load appointments list on page load
                loadAppointmentsList();
            });
        </script>
    @endpush
@endsection
