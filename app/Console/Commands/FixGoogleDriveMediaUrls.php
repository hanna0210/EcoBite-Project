<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FixGoogleDriveMediaUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gdrive:fix-media-urls {--force : Force update all media files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Google Drive media URLs by storing file IDs in custom properties';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing Google Drive media URLs...');
        $this->line('');

        // Get all media files stored on Google Drive
        $query = Media::where('disk', 'gdrive');
        
        if (!$this->option('force')) {
            // Only fix files that don't have the file ID stored
            $query->whereJsonDoesntContain('custom_properties->google_drive_file_id', null);
            $query->orWhereNull('custom_properties');
        }
        
        $mediaFiles = $query->get();
        
        if ($mediaFiles->isEmpty()) {
            $this->info('No media files need fixing.');
            return 0;
        }

        $this->info("Found {$mediaFiles->count()} media files to fix.");
        $this->line('');

        $bar = $this->output->createProgressBar($mediaFiles->count());
        $bar->start();

        $fixed = 0;
        $failed = 0;

        foreach ($mediaFiles as $media) {
            try {
                $this->fixMedia($media);
                $fixed++;
            } catch (\Exception $e) {
                $failed++;
                Log::warning('Failed to fix media file', [
                    'media_id' => $media->id,
                    'file_name' => $media->file_name,
                    'error' => $e->getMessage()
                ]);
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->line('');

        $this->info("✅ Fixed: {$fixed}");
        if ($failed > 0) {
            $this->warn("⚠️  Failed: {$failed}");
            $this->line('Check logs for details: storage/logs/laravel.log');
        }

        $this->line('');
        $this->info('Done!');

        return 0;
    }

    /**
     * Fix a single media file
     */
    private function fixMedia(Media $media): void
    {
        $disk = Storage::disk('gdrive');
        $path = $media->getPath();
        
        // Get the URL which will trigger file ID caching
        $url = $disk->url($path);
        
        if ($url && $url !== '#') {
            // Extract file ID from URL
            $fileId = null;
            
            // Try CDN format first
            if (preg_match('/googleusercontent\.com\/d\/([^\/\?]+)/', $url, $matches)) {
                $fileId = $matches[1];
            }
            // Fallback to old format
            else if (preg_match('/[?&]id=([^&]+)/', $url, $matches)) {
                $fileId = $matches[1];
                // Convert to CDN URL format (no CORS issues)
                $url = "https://lh3.googleusercontent.com/d/{$fileId}";
            }
            
            if ($fileId) {
                // Store in custom properties
                $media->setCustomProperty('google_drive_file_id', $fileId);
                $media->setCustomProperty('google_drive_url', $url);
                $media->saveQuietly();
                
                $this->line('');
                $this->line("Fixed: {$media->file_name} (ID: {$media->id})");
                $this->line("  URL: {$url}");
            }
        }
    }
}

