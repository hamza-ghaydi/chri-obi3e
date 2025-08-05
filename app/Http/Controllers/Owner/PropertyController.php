<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Category;
use App\Models\City;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $properties = Property::with(['category', 'city', 'images'])
            ->where('owner_id', Auth::id())
            ->latest()
            ->paginate(12);

        $stats = [
            'total' => Property::where('owner_id', Auth::id())->count(),
            'published' => Property::where('owner_id', Auth::id())->where('status', 'approved')->where('payment_completed', true)->count(),
            'pending' => Property::where('owner_id', Auth::id())->where('status', 'pending')->count(),
            'draft' => Property::where('owner_id', Auth::id())->where('status', 'draft')->count(),
        ];

        return view('owner.properties.index', compact('properties', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();

        return view('owner.properties.create', compact('categories', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'listing_type' => 'required|in:sale,rent',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validated['owner_id'] = Auth::id();
        $validated['status'] = $request->has('submit_for_review') ? 'pending' : 'draft';

        $property = Property::create($validated);

        
        if ($request->hasFile('images')) {
            $this->handleImageUploads($request->file('images'), $property);
        }

        $message = $property->status === 'pending'
            ? 'Property submitted for review successfully!'
            : 'Property saved as draft successfully!';

        return redirect()->route('owner.properties.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property): View
    {
        
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        $property->load(['category', 'city', 'images', 'appointments.client']);

        return view('owner.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property): View
    {
        // Ensure the property belongs to the authenticated owner
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();
        $property->load('images');

        return view('owner.properties.edit', compact('property', 'categories', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        // Ensure the property belongs to the authenticated owner
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'listing_type' => 'required|in:sale,rent',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'remove_images' => 'nullable|array',
        ]);

        // Update property status if resubmitting
        if ($request->has('submit_for_review') && $property->status === 'draft') {
            $validated['status'] = 'pending';
        }

        $property->update($validated);

        // Handle image removal
        if ($request->has('remove_images')) {
            $this->removeImages($request->remove_images);
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $this->handleImageUploads($request->file('images'), $property);
        }

        return redirect()->route('owner.properties.index')->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('owner.properties.index')->with('success', 'Property deleted successfully!');
    }

    private function handleImageUploads(array $images, Property $property): void
    {
        $manager = new ImageManager(new Driver());

        foreach ($images as $index => $image) {
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $path = 'properties/' . $property->id . '/' . $filename;

            // Resize and optimize image
            $processedImage = $manager->read($image->getPathname())
                ->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            
            Storage::disk('public')->put($path, $processedImage->encode());

            
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'alt_text' => $property->title . ' - Image ' . ($index + 1),
                'sort_order' => $index,
                'is_featured' => $index === 0, 
            ]);
        }

        
        if (!$property->featured_image && $property->images()->count() > 0) {
            $property->update([
                'featured_image' => $property->images()->first()->image_path
            ]);
        }
    }

    /**
     * Remove specified images
     */
    private function removeImages(array $imageIds): void
    {
        $images = PropertyImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }
}
