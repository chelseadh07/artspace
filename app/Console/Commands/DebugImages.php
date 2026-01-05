<?php

namespace App\Console\Commands;

use App\Models\Artwork;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DebugImages extends Command
{
    protected $signature = 'debug:images {--fix}';
    protected $description = 'Debug and fix image issues in production';

    public function handle()
    {
        $this->info('🔍 Checking image configuration and storage...');
        $this->line('');

        // Check 1: Storage configuration
        $this->info('1️⃣ Storage Configuration:');
        $this->line('   FILESYSTEM_DISK: ' . config('filesystems.default'));
        $this->line('   Public disk root: ' . config('filesystems.disks.public.root'));
        $this->line('   Public disk URL: ' . config('filesystems.disks.public.url'));
        $this->line('');

        // Check 2: Storage directory exists
        $this->info('2️⃣ Storage Directory Check:');
        $storagePath = storage_path('app/public');
        $this->line('   Path: ' . $storagePath);
        $this->line('   Exists: ' . (is_dir($storagePath) ? '✅ YES' : '❌ NO'));
        
        if (is_dir($storagePath)) {
            $artworksPath = $storagePath . '/artworks';
            $servicesPath = $storagePath . '/services';
            $this->line('   - artworks/ exists: ' . (is_dir($artworksPath) ? '✅ YES' : '⚠️ NO'));
            $this->line('   - services/ exists: ' . (is_dir($servicesPath) ? '✅ YES' : '⚠️ NO'));
        }
        $this->line('');

        // Check 3: Public symlink
        $this->info('3️⃣ Public/Storage Symlink:');
        $symlinkPath = public_path('storage');
        $this->line('   Path: ' . $symlinkPath);
        $this->line('   Is symlink: ' . (is_link($symlinkPath) ? '✅ YES' : '❌ NO'));
        if (is_link($symlinkPath)) {
            $this->line('   Points to: ' . readlink($symlinkPath));
        }
        $this->line('');

        // Check 4: Sample artworks
        $this->info('4️⃣ Sample Artworks in Database:');
        $artworks = Artwork::whereNotNull('image_url')->limit(3)->get();
        if ($artworks->count() > 0) {
            foreach ($artworks as $art) {
                $this->line('   Artwork #' . $art->artwork_id . ':');
                $this->line('      DB image_url: ' . $art->image_url);
                $this->line('      Full path: ' . storage_path('app/public/' . $art->image_url));
                $this->line('      File exists: ' . (Storage::disk('public')->exists($art->image_url) ? '✅ YES' : '❌ NO'));
                $this->line('      Access URL: ' . asset('storage/' . $art->image_url));
                $this->line('');
            }
        } else {
            $this->line('   No artworks found');
        }
        $this->line('');

        // Check 5: Sample services
        $this->info('5️⃣ Sample Services in Database:');
        $services = Service::whereNotNull('thumbnail')->limit(3)->get();
        if ($services->count() > 0) {
            foreach ($services as $svc) {
                $this->line('   Service #' . $svc->service_id . ':');
                $this->line('      DB thumbnail: ' . $svc->thumbnail);
                $this->line('      Full path: ' . storage_path('app/public/' . $svc->thumbnail));
                $this->line('      File exists: ' . (Storage::disk('public')->exists($svc->thumbnail) ? '✅ YES' : '❌ NO'));
                $this->line('      Access URL: ' . asset('storage/' . $svc->thumbnail));
                $this->line('');
            }
        } else {
            $this->line('   No services with thumbnails found');
        }
        $this->line('');

        // Fix if requested
        if ($this->option('fix')) {
            $this->info('🔧 Attempting fixes...');
            $this->line('');

            // Create symlink if missing
            if (!is_link($symlinkPath)) {
                $this->line('Creating symlink...');
                try {
                    app('files')->link(
                        storage_path('app/public'),
                        public_path('storage')
                    );
                    $this->line('✅ Symlink created');
                } catch (\Exception $e) {
                    $this->line('❌ Failed to create symlink: ' . $e->getMessage());
                }
            }

            // Create directories if missing
            if (!is_dir($storagePath . '/artworks')) {
                File::makeDirectory($storagePath . '/artworks', 0755, true);
                $this->line('✅ Created artworks directory');
            }
            if (!is_dir($storagePath . '/services')) {
                File::makeDirectory($storagePath . '/services', 0755, true);
                $this->line('✅ Created services directory');
            }

            $this->line('');
            $this->info('✅ Fixes complete! Try uploading new images or redeploy.');
        }

        if (!$this->option('fix')) {
            $this->line('Run with --fix flag to attempt repairs: php artisan debug:images --fix');
        }
    }
}
