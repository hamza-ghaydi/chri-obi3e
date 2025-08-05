<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'description' => 'Modern apartments in prime locations',
                'is_active' => true,
            ],
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'description' => 'Luxury villas with gardens and pools',
                'is_active' => true,
            ],
            [
                'name' => 'Studio',
                'slug' => 'studio',
                'description' => 'Compact studio apartments perfect for singles',
                'is_active' => true,
            ],
            [
                'name' => 'Terrain',
                'slug' => 'terrain',
                'description' => 'Land plots for construction or investment',
                'is_active' => true,
            ],
            [
                'name' => 'Penthouse',
                'slug' => 'penthouse',
                'description' => 'Exclusive penthouses with panoramic views',
                'is_active' => true,
            ],
            [
                'name' => 'Townhouse',
                'slug' => 'townhouse',
                'description' => 'Multi-level townhouses with private entrances',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
