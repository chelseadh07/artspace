<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'bio' => 'Seeded admin account'
            ]
        );

        // Artist account for testing
        User::updateOrCreate(
            ['email' => 'artist@example.com'],
            [
                'name' => 'John Artist',
                'password' => Hash::make('artist123'),
                'role' => 'artist',
                'bio' => 'Professional digital artist specializing in portraits and illustrations'
            ]
        );

        // Buyer account for testing
        User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Sarah Buyer',
                'password' => Hash::make('buyer123'),
                'role' => 'client',
                'bio' => 'Art enthusiast and collector'
            ]
        );
    }
}
