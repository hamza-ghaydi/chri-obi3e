<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //

    public function index(): View
    {
        $user = Auth::user();

        // statistics dyal clients
        $stats = [
            'favorites_count' => Favorite::where('client_id', $user->id)->count(),
            'appointments_count' => Appointment::where('client_id', $user->id)->count(),
            'pending_appointments' => Appointment::where('client_id', $user->id)->pending()->count(),
            'confirmed_appointments' => Appointment::where('client_id', $user->id)->confirmed()->count(),
        ];

        // favorites
        $recentFavorites = Favorite::with(['property.category', 'property.city', 'property.images'])
            ->where('client_id', $user->id)
            ->latest()
            ->limit(6)
            ->get();

        // Get upcoming appointments
        $upcomingAppointments = Appointment::with(['property', 'owner'])
            ->where('client_id', $user->id)
            ->upcoming()
            ->confirmed()
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        
        $recentActivity = Appointment::with(['property', 'owner'])
            ->where('client_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        
        $favoriteCategories = Favorite::join('properties', 'favorites.property_id', '=', 'properties.id')
            ->where('favorites.client_id', $user->id)
            ->pluck('properties.category_id')
            ->unique();

        $recommendedProperties = Property::with(['category', 'city', 'images'])
            ->published()
            ->whereIn('category_id', $favoriteCategories)
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('property_id')
                    ->from('favorites')
                    ->where('client_id', $user->id);
            })
            ->limit(4)
            ->get();

        return view('client.dashboard', compact(
            'stats',
            'recentFavorites',
            'upcomingAppointments',
            'recentActivity',
            'recommendedProperties'
        ));
    }
}
