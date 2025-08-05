<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $favorites = Favorite::with(['property.category', 'property.city', 'property.images', 'property.owner'])
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('client.favorites.index', compact('favorites'));
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
    public function store(Request $request, Property $property): RedirectResponse
    {
        $favorite = Favorite::where('client_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            return back()->with('error', 'Property is already in your favorites.');
        }

        Favorite::create([
            'client_id' => Auth::id(),
            'property_id' => $property->id,
        ]);

        return back()->with('success', 'Property added to favorites.');
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
    public function destroy(Property $property): RedirectResponse
    {
        $favorite = Favorite::where('client_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Property removed from favorites.');
        }

        return back()->with('error', 'Property not found in favorites.');
    }
}
