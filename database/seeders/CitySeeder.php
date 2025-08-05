<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cities = [
            [
                'name' => 'Casablanca',
                'slug' => 'casablanca',
                'state' => 'Casablanca-Settat',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Rabat',
                'slug' => 'rabat',
                'state' => 'Rabat-Salé-Kénitra',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Marrakech',
                'slug' => 'marrakech',
                'state' => 'Marrakech-Safi',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Fez',
                'slug' => 'fez',
                'state' => 'Fès-Meknès',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Tangier',
                'slug' => 'tangier',
                'state' => 'Tanger-Tétouan-Al Hoceïma',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Agadir',
                'slug' => 'agadir',
                'state' => 'Souss-Massa',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Meknes',
                'slug' => 'meknes',
                'state' => 'Fès-Meknès',
                'country' => 'Morocco',
                'is_active' => true,
            ],
            [
                'name' => 'Oujda',
                'slug' => 'oujda',
                'state' => 'Oriental',
                'country' => 'Morocco',
                'is_active' => true,
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
