<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
   {
        $appointments = Appointment::with(['property', 'owner'])
            ->where('client_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        // Calculate statistics
        $totalAppointments = $appointments->count();
        $upcomingAppointments = $appointments->where('appointment_date', '>', now())->count();
        $confirmedAppointments = $appointments->where('status', 'confirmed')->count();
        $pendingAppointments = $appointments->where('status', 'pending')->count();

        return view('client.appointments.index', compact(
            'appointments',
            'totalAppointments',
            'upcomingAppointments',
            'confirmedAppointments',
            'pendingAppointments'
        ));
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
}
