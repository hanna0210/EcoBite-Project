<?php

namespace App\Support\MediaLibrary\UrlGenerator;

use DateTimeInterface;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;
use Illuminate\Support\Facades\Storage;

class GoogleDriveUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        // First, try to get URL from custom properties (cached during upload)
        if ($this->media) {
            $cachedUrl = $this->media->getCustomProperty('google_drive_url');
            if ($cachedUrl) {
                return $cachedUrl;
            }
            
            // Try to get file ID from custom properties
            $fileId = $this->media->getCustomProperty('google_drive_file_id');
            if ($fileId) {
                // Generate CDN URL from file ID - more reliable, no CORS/CORB issues
                $url = "https://lh3.googleusercontent.com/d/{$fileId}";
                
                // Cache it for next time
                try {
                    $this->media->setCustomProperty('google_drive_url', $url);
                    $this->media->saveQuietly();
                } catch (\Exception $e) {
                    // Ignore save errors
                }
                
                return $url;
            }
        }
        
        // Fallback: try to get URL from disk
        try {
            $path = $this->getPathRelativeToRoot();
            $url = Storage::disk($this->media->disk)->url($path);
            
            // If URL is valid, return it
            if ($url && $url !== '#') {
                return $url;
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->warning('Failed to get Google Drive URL', [
                'media_id' => $this->media->id ?? null,
                'path' => $this->getPathRelativeToRoot(),
                'error' => $e->getMessage()
            ]);
        }
        
        // Return a placeholder if URL generation fails
        return '#';
    }

    public function getPath(): string
    {
        return $this->getPathRelativeToRoot();
    }

    public function setMedia(Media $media): self
    {
        $this->media = $media;
        return $this;
    }

    public function setConversion(Conversion $conversion): self
    {
        $this->conversion = $conversion;
        return $this;
    }

    public function setPathGenerator(PathGenerator $pathGenerator): self
    {
        $this->pathGenerator = $pathGenerator;
        return $this;
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        // For Google Drive, we'll return the regular URL since Google Drive files
        // are typically publicly accessible or require authentication
        return $this->getUrl();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $baseUrl = $this->getUrl();
        $pathInfo = pathinfo($baseUrl);
        
        return $pathInfo['dirname'] . '/responsive-images/';
    }
}
