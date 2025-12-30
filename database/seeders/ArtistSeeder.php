<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Test Artist 2',
            'email' => 'testartist2@example.com',
            'password' => bcrypt('password123'),
            'role' => 'artist',
            'bio' => 'Test artist account',
            'avatar' => 'https://via.placeholder.com/150',
        ]);
    }
}
