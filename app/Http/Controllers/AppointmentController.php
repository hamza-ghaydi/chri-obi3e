<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentRequestNotification;
use App\Mail\AppointmentConfirmedNotification;
use App\Mail\AppointmentRejectedNotification;

class AppointmentController extends Controller
{
    
    public function create(Property $property): View
    {
        // check if property is available
        if (!$property->isPublished()) {
            abort(404, 'Property not available');
        }

        
        $existingAppointments = Appointment::where('property_id', $property->id)
            ->where('status', '!=', 'rejected')
            ->get(['appointment_date', 'status']);

        return view('appointments.create', compact('property', 'existingAppointments'));
    }

    
    public function store(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after:now',
            'client_message' => 'nullable|string|max:500',
        ]);

        // Check if slot is already taken
        $existingAppointment = Appointment::where('property_id', $property->id)
            ->where('appointment_date', $validated['appointment_date'])
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_date' => 'This time slot is already taken. Please choose another time.']);
        }

        // Create appointment
        $appointment = Appointment::create([
            'property_id' => $property->id,
            'client_id' => Auth::id(),
            'owner_id' => $property->owner_id,
            'appointment_date' => $validated['appointment_date'],
            'client_message' => $validated['client_message'],
            'status' => 'pending',
        ]);

        // Send email notification to owner
        try {
            Mail::to($property->owner->email)->send(new AppointmentRequestNotification($appointment));
        } catch (\Exception $e) {
            Log::error('Failed to send appointment notification email: ' . $e->getMessage());
        }

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Your appointment request has been sent to the property owner!');
    }

    
    public function show(Appointment $appointment): View
    {
        // check if user can view this appointment
        if ($appointment->client_id !== Auth::id() && $appointment->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Update appointment status (for owners)
     */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        // check if only owner can update status
        if ($appointment->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected',
            'owner_response' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'status' => $validated['status'],
            'owner_response' => $validated['owner_response'],
            'confirmed_at' => $validated['status'] === 'confirmed' ? now() : null,
            'rejected_at' => $validated['status'] === 'rejected' ? now() : null,
        ]);

        // Send confirmation email to client
        try {
            if ($validated['status'] === 'confirmed') {
                Mail::to($appointment->client->email)->send(new AppointmentConfirmedNotification($appointment));
            } else {
                Mail::to($appointment->client->email)->send(new AppointmentRejectedNotification($appointment));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send appointment status email: ' . $e->getMessage());
        }

        $message = $validated['status'] === 'confirmed'
            ? 'Appointment confirmed successfully!'
            : 'Appointment rejected.';

        return back()->with('success', $message);
    }
}
