<?php

namespace App\Support\MediaLibrary\UrlGenerator;

use DateTimeInterface;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class GoogleDriveUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        // For Google Drive, we need to return the direct file URL
        // This will be the Google Drive file URL that can be accessed publicly
        $disk = $this->getDisk();
        
        // Check if the disk has a url method (our custom adapter)
        if (method_exists($disk, 'url')) {
            return $disk->url($this->getPathRelativeToRoot());
        }
        
        // Fallback to default behavior
        return $disk->url($this->getPathRelativeToRoot());
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
