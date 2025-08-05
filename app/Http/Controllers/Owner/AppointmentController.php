<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Property;
use App\Mail\AppointmentStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stats = [
            'total' => Appointment::where('owner_id', Auth::id())->count(),
            'pending' => Appointment::where('owner_id', Auth::id())->pending()->count(),
            'confirmed' => Appointment::where('owner_id', Auth::id())->confirmed()->count(),
            'this_week' => Appointment::where('owner_id', Auth::id())
                ->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        $properties = Property::where('owner_id', Auth::id())
            ->select('id', 'title')
            ->get();

        return view('owner.appointments.index', compact('stats', 'properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // appointments f calendar
    public function getAppointments(Request $request): JsonResponse
    {
        $appointments = Appointment::with(['property', 'client'])
            ->where('owner_id', Auth::id())
            ->when($request->start, function ($query) use ($request) {
                $query->where('appointment_date', '>=', $request->start);
            })
            ->when($request->end, function ($query) use ($request) {
                $query->where('appointment_date', '<=', $request->end);
            })
            ->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->client->name . ' - ' . $appointment->property->title,
                'start' => $appointment->appointment_date->toISOString(),
                'backgroundColor' => $this->getStatusColor($appointment->status),
                'borderColor' => $this->getStatusColor($appointment->status),
                'extendedProps' => [
                    'client_name' => $appointment->client->name,
                    'client_phone' => $appointment->client->phone,
                    'property_title' => $appointment->property->title,
                    'status' => $appointment->status,
                    'message' => $appointment->client_message,
                ],
            ];
        });

        return response()->json($events);
    }


    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        // Ensure the appointment belongs to the authenticated owner
        if ($appointment->owner_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected',
            'response' => 'nullable|string',
        ]);

        $appointment->update([
            'status' => $validated['status'],
            'owner_response' => $validated['response'] ?? null,
            $validated['status'] . '_at' => now(),
        ]);

        // Send email notification to client
        try {
            Mail::to($appointment->client->email)
                ->send(new AppointmentStatusUpdated($appointment));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            Log::error('Failed to send appointment status email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Appointment ' . $validated['status'] . ' successfully! Client has been notified via email.',
        ]);
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => '#f59e0b',    // yellow
            'confirmed' => '#10b981',  // green
            'rejected' => '#ef4444',   // red
            'completed' => '#6366f1',  // indigo
            'cancelled' => '#6b7280',  // gray
            default => '#6b7280',
        };
    }
}
