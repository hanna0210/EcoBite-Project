<?php

namespace App\Observers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        // Only process Google Drive files
        if ($media->disk === 'gdrive') {
            $this->storeGoogleDriveFileId($media);
        }
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void
    {
        // Only process Google Drive files
        if ($media->disk === 'gdrive') {
            // Check if file ID is already stored
            if (empty($media->getCustomProperty('google_drive_file_id'))) {
                $this->storeGoogleDriveFileId($media);
            }
        }
    }

    /**
     * Store the Google Drive file ID in media custom properties
     */
    private function storeGoogleDriveFileId(Media $media): void
    {
        try {
            $disk = Storage::disk('gdrive');
            $path = $media->getPath();
            
            // Get the Google Drive adapter
            $adapter = $disk->getAdapter();
            
            // If the adapter has a url method, call it to ensure file is uploaded and cached
            if (method_exists($adapter, 'url')) {
                $url = $disk->url($path);
                
                // Extract file ID from the URL
                // URL format could be: https://lh3.googleusercontent.com/d/{fileId}
                // Or fallback: https://drive.google.com/uc?export=view&id={fileId}
                $fileId = null;
                
                // Try CDN format first
                if (preg_match('/googleusercontent\.com\/d\/([^\/\?]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                }
                // Fallback to old format
                else if (preg_match('/[?&]id=([^&]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                    // Convert to CDN URL format
                    $url = "https://lh3.googleusercontent.com/d/{$fileId}";
                }
                
                if ($fileId) {
                    // Store the file ID in custom properties
                    $media->setCustomProperty('google_drive_file_id', $fileId);
                    $media->setCustomProperty('google_drive_url', $url);
                    $media->saveQuietly(); // Save without triggering events again
                    
                    Log::info('Google Drive file ID stored', [
                        'media_id' => $media->id,
                        'file_id' => $fileId,
                        'url' => $url,
                        'path' => $path
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to store Google Drive file ID', [
                'media_id' => $media->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

