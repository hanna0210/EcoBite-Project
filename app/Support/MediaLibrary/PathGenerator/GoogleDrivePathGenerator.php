<?php

namespace App\Support\MediaLibrary\PathGenerator;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class GoogleDrivePathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // Generate a path structure for Google Drive
        // Format: {model_type}/{model_id}/{collection_name}/
        // Note: Do NOT include filename here - Spatie Media Library adds it automatically
        $modelType = class_basename($media->model_type);
        $modelId = $media->model_id;
        $collectionName = $media->collection_name;
        
        return "{$modelType}/{$modelId}/{$collectionName}/";
    }

    public function getPathForConversions(Media $media): string
    {
        // Generate path for conversions
        $basePath = $this->getPath($media);
        $pathInfo = pathinfo($basePath);
        
        return $pathInfo['dirname'] . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        // Generate path for responsive images
        $basePath = $this->getPath($media);
        $pathInfo = pathinfo($basePath);
        
        return $pathInfo['dirname'] . '/responsive-images/';
    }
}

