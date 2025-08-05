<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Property $property): View
    {
        // Load relationships
        $property->load(['category', 'city', 'owner', 'images']);

        // Check if property is published
        if (!$property->published_at || $property->status !== 'approved') {
            abort(404);
        }

        // Check if user has favorited this property
        $isFavorited = false;
        if (Auth::check() && Auth::user()->isClient()) {
            $isFavorited = Favorite::where('client_id', Auth::id())
                ->where('property_id', $property->id)
                ->exists();
        }

        // Get similar properties
        $similarProperties = Property::with(['category', 'city', 'images'])
            ->published()
            ->where('id', '!=', $property->id)
            ->where(function ($query) use ($property) {
                $query->where('category_id', $property->category_id)
                      ->orWhere('city_id', $property->city_id);
            })
            ->limit(4)
            ->get();

        return view('properties.show', compact(
            'property',
            'isFavorited',
            'similarProperties'
        ));
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

    // toggle favorite
    public function toggleFavorite(Request $request, Property $property): RedirectResponse
    {
        if (!Auth::check() || !Auth::user()->isClient()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in as a client to favorite properties.');
        }

        $favorite = Favorite::where('client_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Property removed from favorites.';
        } else {
            Favorite::create([
                'client_id' => Auth::id(),
                'property_id' => $property->id,
            ]);
            $message = 'Property added to favorites.';
        }

        return back()->with('success', $message);
    }
}
