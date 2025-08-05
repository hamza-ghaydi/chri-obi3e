<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = User::where('role', 'owner')->get();
        $categories = Category::all();
        $cities = City::all();

        $properties = [
            [
                'title' => 'Luxury Villa in Casablanca',
                'description' => 'Beautiful 4-bedroom villa with swimming pool and garden. Located in the prestigious Anfa district with modern amenities and stunning architecture.',
                'price' => 2500000,
                'listing_type' => 'sale',
                'address' => 'Anfa District, Casablanca',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 350,
                'features' => ['Swimming Pool', 'Garden', 'Garage', 'Security System', 'Modern Kitchen'],
                'is_featured' => true,
                'status' => 'approved',
                'payment_completed' => true,
                'approved_at' => now(),
                'published_at' => now(),
            ],
            [
                'title' => 'Modern Apartment in Rabat',
                'description' => 'Spacious 3-bedroom apartment in the heart of Rabat. Close to amenities and public transport.',
                'price' => 1200000,
                'listing_type' => 'sale',
                'address' => 'Agdal, Rabat',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 120,
                'features' => ['Balcony', 'Elevator', 'Parking', 'Central Heating'],
                'is_featured' => false,
                'status' => 'approved',
                'payment_completed' => true,
                'approved_at' => now(),
                'published_at' => now(),
            ],
            [
                'title' => 'Studio for Rent in Marrakech',
                'description' => 'Cozy studio apartment perfect for students or young professionals. Fully furnished with modern appliances.',
                'price' => 3500,
                'listing_type' => 'rent',
                'address' => 'Gueliz, Marrakech',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area' => 45,
                'features' => ['Furnished', 'Air Conditioning', 'WiFi', 'Kitchen'],
                'is_featured' => true,
                'status' => 'approved',
                'payment_completed' => true,
                'approved_at' => now(),
                'published_at' => now(),
            ],
        ];

        foreach ($properties as $index => $propertyData) {
            $property = Property::create([
                'owner_id' => $owners->random()->id,
                'category_id' => $categories->random()->id,
                'city_id' => $cities->random()->id,
                ...$propertyData
            ]);
        }
    }
}
