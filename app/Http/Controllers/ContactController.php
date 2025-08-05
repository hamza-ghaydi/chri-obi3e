<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactOwnerNotification;


class ContactController extends Controller
{
    public function create(Property $property): View
    {
        // check if property is available for contact
        if (!$property->isPublished()) {
            abort(404, 'Property not available');
        }

        return view('properties.contact', compact('property'));
    }

    
     //Store the contact request
     
    public function store(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Create contact record
        $contact = Contact::create([
            'client_id' => Auth::id(),
            'property_id' => $property->id,
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        // Send email notification to owner
        try {
            Mail::to($property->owner->email)->send(new ContactOwnerNotification($contact));
        } catch (\Exception $e) {
            
            Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }

        
        return redirect()->route('appointments.create', $property)
            ->with('success', 'Your message has been sent to the property owner! Now you can schedule a visit.');
    }
}
