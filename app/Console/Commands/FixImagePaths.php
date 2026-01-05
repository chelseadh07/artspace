<?php

namespace App\Console\Commands;

use App\Models\Artwork;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixImagePaths extends Command
{
    protected $signature = 'fix:image-paths';
    protected $description = 'Fix incorrect image paths in database';

    public function handle()
    {
        $this->info('🔧 Fixing image paths in database...');
        $this->line('');

        $fixedArtworks = 0;
        $fixedServices = 0;

        // Fix artworks
        $this->info('Processing artworks...');
        $artworks = Artwork::whereNotNull('image_url')->get();
        
        foreach ($artworks as $art) {
            $oldPath = $art->image_url;
            $newPath = $oldPath;

            // Remove /storage/ prefix if it exists
            if (str_starts_with($newPath, '/storage/')) {
                $newPath = substr($newPath, 9); // Remove '/storage/'
            }

            // Remove full URL if stored
            if (str_starts_with($newPath, 'http://') || str_starts_with($newPath, 'https://')) {
                // Extract just the path after /storage/
                $newPath = str_replace(config('app.url') . '/storage/', '', $newPath);
            }

            if ($oldPath !== $newPath) {
                $art->image_url = $newPath;
                $art->save();
                $this->line("   Updated: {$oldPath} → {$newPath}");
                $fixedArtworks++;
            }
        }

        $this->line('');
        $this->info('Processing services...');
        
        // Fix services
        $services = Service::whereNotNull('thumbnail')->get();
        
        foreach ($services as $svc) {
            $oldPath = $svc->thumbnail;
            $newPath = $oldPath;

            // Remove /storage/ prefix if it exists
            if (str_starts_with($newPath, '/storage/')) {
                $newPath = substr($newPath, 9); // Remove '/storage/'
            }

            // Remove full URL if stored
            if (str_starts_with($newPath, 'http://') || str_starts_with($newPath, 'https://')) {
                // Extract just the path after /storage/
                $newPath = str_replace(config('app.url') . '/storage/', '', $newPath);
            }

            if ($oldPath !== $newPath) {
                $svc->thumbnail = $newPath;
                $svc->save();
                $this->line("   Updated: {$oldPath} → {$newPath}");
                $fixedServices++;
            }
        }

        $this->line('');
        $this->info("✅ Fixed {$fixedArtworks} artworks and {$fixedServices} services");
        $this->line('');
        $this->comment('Now run: php artisan debug:images');
    }
}
