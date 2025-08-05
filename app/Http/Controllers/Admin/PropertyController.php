<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Property::with(['owner', 'category', 'city', 'images']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by listing type
        if ($request->filled('type')) {
            $query->where('listing_type', $request->type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total' => Property::count(),
            'pending' => Property::where('status', 'pending')->count(),
            'approved' => Property::where('status', 'approved')->count(),
            'rejected' => Property::where('status', 'rejected')->count(),
        ];

        return view('admin.properties.index', compact('properties', 'stats'));
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
        $property->load(['owner', 'category', 'city', 'images', 'appointments.client']);

        return view('admin.properties.show', compact('property'));
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
        // Delete images
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully!');
    }

     // update property status
    public function updateStatus(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $property->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            $validated['status'] . '_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        $message = $validated['status'] === 'approved'
            ? 'Property approved successfully!'
            : 'Property rejected.';

        return redirect()->route('admin.properties.index')
            ->with('success', $message);
    }

    // update multiple properties
    public function bulkUpdate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $updated = Property::whereIn('id', $validated['property_ids'])
            ->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
                $validated['status'] . '_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} properties updated successfully!",
        ]);
    }
}
