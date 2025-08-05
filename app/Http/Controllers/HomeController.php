<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        // filter by parameters
        $filters = $request->only(['status', 'category', 'city', 'min_price', 'max_price', 'search']);

        
        $query = Property::with(['category', 'city', 'owner', 'images'])
            ->published()
            ->latest('published_at');

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('listing_type', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['city'])) {
            $query->where('city_id', $filters['city']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('address', 'like', '%' . $filters['search'] . '%');
            });
        }

        // pagination
        $properties = $query->paginate(12)->withQueryString();

        
        $featuredProperties = Property::with(['category', 'city', 'owner', 'images'])
            ->published()
            ->featured()
            ->limit(6)
            ->get();

        // Get filter options
        $categories = Category::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();

        return view('home.index', compact(
            'properties',
            'featuredProperties',
            'categories',
            'cities',
            'filters'
        ));
    }
}
