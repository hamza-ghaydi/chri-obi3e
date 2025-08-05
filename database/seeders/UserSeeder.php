<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@chriwbi3.com',
            'phone' => '+212 123 456 789',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'contact_info' => 'Main administrator of the platform',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Property Owners
        $owners = [
            [
                'name' => 'Ahmed Benali',
                'email' => 'ahmed@example.com',
                'phone' => '+212 661 234 567',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'contact_info' => 'Experienced property developer in Casablanca',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Fatima Zahra',
                'email' => 'fatima@example.com',
                'phone' => '+212 662 345 678',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'contact_info' => 'Luxury property specialist in Marrakech',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mohamed Alami',
                'email' => 'mohamed@example.com',
                'phone' => '+212 663 456 789',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'contact_info' => 'Real estate investor with multiple properties',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($owners as $owner) {
            User::create($owner);
        }

        // Create Clients
        $clients = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'phone' => '+212 664 567 890',
                'password' => Hash::make('password'),
                'role' => 'client',
                'contact_info' => 'Looking for a family home in Rabat',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Omar Idrissi',
                'email' => 'omar@example.com',
                'phone' => '+212 665 678 901',
                'password' => Hash::make('password'),
                'role' => 'client',
                'contact_info' => 'First-time buyer interested in apartments',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($clients as $client) {
            User::create($client);
        }
    }
}
