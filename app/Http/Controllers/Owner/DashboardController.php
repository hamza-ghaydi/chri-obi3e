<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(): View
    {
        $owner = Auth::user();

        // moul property
        $properties = Property::where('owner_id', $owner->id)->get();
        $propertyIds = $properties->pluck('id');

        // statistics dyal appointments
        $appointmentStats = [
            'total' => Appointment::whereIn('property_id', $propertyIds)->count(),
            'pending' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'pending')->count(),
            'confirmed' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'confirmed')->count(),
            'rejected' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'rejected')->count(),
        ];

        // akhir appointments
        $recentAppointments = Appointment::with(['client', 'property'])
            ->whereIn('property_id', $propertyIds)
            ->latest()
            ->limit(5)
            ->get();

        // statistics dyal properties
        $propertyStats = [
            'total' => $properties->count(),
            'published' => $properties->where('status', 'approved')->count(),
            'pending' => $properties->where('status', 'pending')->count(),
            'draft' => $properties->where('status', 'draft')->count(),
        ];

        return view('owner.dashboard', compact(
            'appointmentStats',
            'propertyStats',
            'recentAppointments',
            'properties'
        ));
    }
}
