<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Artwork;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Painting', 'description' => 'Oil, acrylic, watercolor paintings'],
            ['name' => 'Sculpture', 'description' => 'Marble, wood, metal sculptures'],
            ['name' => 'Digital Art', 'description' => 'Graphics, illustrations, 3D art'],
            ['name' => 'Photography', 'description' => 'Portrait, landscape, event photography'],
            ['name' => 'Graphic Design', 'description' => 'Logos, branding, web design'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], ['description' => $cat['description']]);
        }

        // Create test admin
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create test artist
        $artist = User::firstOrCreate(
            ['email' => 'artist@test.com'],
            [
                'name' => 'Kiara Artist',
                'password' => Hash::make('artist123'),
                'role' => 'artist',
                'bio' => 'Professional digital artist and designer',
            ]
        );

        // Create test buyer
        $buyer = User::firstOrCreate(
            ['email' => 'buyer@test.com'],
            [
                'name' => 'Febby Buyer',
                'password' => Hash::make('buyer123'),
                'role' => 'client',
                'bio' => 'Art collector and design enthusiast',
            ]
        );

        // Create sample artworks for artist
        $paintingCat = Category::where('name', 'Painting')->first();
        $digitalCat = Category::where('name', 'Digital Art')->first();

        Artwork::firstOrCreate(
            ['title' => 'Sunset Dreams'],
            [
                'user_id' => $artist->user_id,
                'description' => 'A beautiful landscape painting capturing the essence of sunset.',
                'image_url' => 'artworks/sample1.jpg',
                'category_id' => $paintingCat?->category_id,
            ]
        );

        Artwork::firstOrCreate(
            ['title' => 'Digital Portrait'],
            [
                'user_id' => $artist->user_id,
                'description' => 'Modern digital portrait using latest design techniques.',
                'image_url' => 'artworks/sample2.jpg',
                'category_id' => $digitalCat?->category_id,
            ]
        );

        // Create sample services for artist
        Service::firstOrCreate(
            ['title' => 'Custom Portrait Painting'],
            [
                'user_id' => $artist->user_id,
                'category_id' => $paintingCat?->category_id,
                'description' => 'Create a custom oil portrait from your photo.',
                'base_price' => 150.00,
                'expected_duration' => '2-3 weeks',
                'status' => 'active',
            ]
        );

        Service::firstOrCreate(
            ['title' => 'Digital Logo Design'],
            [
                'user_id' => $artist->user_id,
                'category_id' => Category::where('name', 'Graphic Design')->first()?->category_id,
                'description' => 'Professional logo design for your brand.',
                'base_price' => 100.00,
                'expected_duration' => '1 week',
                'status' => 'active',
            ]
        );
    }
}
